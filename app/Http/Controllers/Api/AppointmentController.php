<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /* ════════════════════════════════════════
       BOOKING — dua jalur:
       1. Poli Umum  → ambil nomor langsung (tanpa pilih dokter/jadwal)
       2. Spesialis  → pilih dokter + jadwal
    ════════════════════════════════════════ */

    public function store(Request $request)
    {
        $user = $request->user();

        // ── Guard profil lengkap ────────────────────────────
        $profile = $user->patientProfile;
        if (!$profile || empty($profile->nik) || empty($profile->phone_number)) {
            return response()->json([
                'message'       => 'Silakan lengkapi data diri (NIK, No HP) sebelum booking.',
                'needs_profile' => true,
                'redirect'      => '/complete-profile',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'poli_id'            => 'required|exists:polis,id',
            // Nomor slot yang dipilih user dari grid (1–50)
            'slot_number'        => 'nullable|integer|min:1|max:50',
            // Spesialis: opsional sertakan jadwal
            'doctor_schedule_id' => 'nullable|exists:doctor_schedules,id',
            // Backup kontak
            'temp_phone'         => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $poli = Poli::findOrFail($request->poli_id);

        // ── Cek apakah user sudah punya antrian aktif di poli ini hari ini ──
        $existing = Appointment::where('user_id', $user->id)
            ->where('poli_id', $poli->id)
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['cancelled', 'no_show', 'completed'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Anda sudah memiliki antrian aktif di poli ini hari ini.',
                'data'    => $this->formatAppointment($existing),
            ], 409);
        }

        // ── Tentukan alur berdasarkan poli ──────────────────
        $isGeneralPoli = strtoupper($poli->code) === 'UMUM';

        if ($isGeneralPoli || !$request->filled('doctor_schedule_id')) {
            return $this->bookGeneralQueue($request, $user, $poli);
        } else {
            return $this->bookSpecialistSlot($request, $user, $poli);
        }
    }

    /* ── Jalur 1: Poli Umum / tanpa jadwal ─── */
    private function bookGeneralQueue(Request $request, $user, Poli $poli)
    {
        // Cek kuota harian poli (max 50)
        $quota = 50;

        $countToday = Appointment::where('poli_id', $poli->id)
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->count();

        if ($countToday >= $quota) {
            return response()->json([
                'message' => "Kuota antrian {$poli->name} hari ini sudah penuh ({$quota} pasien).",
                'is_full' => true,
            ], 422);
        }

        // Jika user memilih slot spesifik, validasi slot belum diambil
        $queueNum = $this->resolveQueueNumber($poli, $request->slot_number);

        if ($queueNum === null) {
            return response()->json([
                'message' => 'Nomor antrian ini sudah diambil orang lain. Pilih nomor lain.',
                'slot_taken' => true,
            ], 409);
        }

        $appointment = Appointment::create([
            'user_id'          => $user->id,
            'poli_id'          => $poli->id,
            'appointment_date' => today()->toDateString(),
            'queue_number'     => $queueNum,
            'status'           => 'pending',
            'temp_phone'       => $request->temp_phone ?? $user->patientProfile?->phone_number,
        ]);

        return response()->json([
            'message' => "Nomor antrian {$queueNum} berhasil diambil!",
            'data'    => $this->formatAppointment($appointment->load(['poli'])),
        ], 201);
    }

    /* ── Jalur 2: Spesialis dengan jadwal dokter ─── */
    private function bookSpecialistSlot(Request $request, $user, Poli $poli)
    {
        $schedule = DoctorSchedule::where('id', $request->doctor_schedule_id)
            ->where('is_available', true)
            ->first();

        if (!$schedule) {
            return response()->json(['message' => 'Jadwal tidak tersedia.'], 422);
        }

        if ((int) $schedule->poli_id !== (int) $poli->id) {
            return response()->json(['message' => 'Jadwal tidak sesuai poli yang dipilih.'], 422);
        }

        // Cek kuota per jadwal
        $booked = Appointment::where('doctor_schedule_id', $schedule->id)
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->count();

        if ($booked >= $schedule->max_patients) {
            return response()->json([
                'message' => 'Kuota jadwal dokter ini sudah penuh.',
                'is_full' => true,
            ], 422);
        }

        // Estimasi waktu (15 menit per pasien)
        $startMinutes = strtotime($schedule->start_time);
        $estTime      = date('H:i:s', $startMinutes + ($booked * 900));

        $queueNum = $this->resolveQueueNumber($poli, $request->slot_number);

        if ($queueNum === null) {
            return response()->json([
                'message'    => 'Nomor antrian ini sudah diambil orang lain. Pilih nomor lain.',
                'slot_taken' => true,
            ], 409);
        }

        $appointment = Appointment::create([
            'user_id'             => $user->id,
            'poli_id'             => $poli->id,
            'doctor_id'           => $schedule->doctor_id,
            'doctor_schedule_id'  => $schedule->id,
            'appointment_date'    => $schedule->schedule_date instanceof Carbon
                ? $schedule->schedule_date->toDateString()
                : $schedule->schedule_date,
            'queue_number'        => $queueNum,
            'estimated_time'      => $estTime,
            'status'              => 'pending',
            'temp_phone'          => $request->temp_phone ?? $user->patientProfile?->phone_number,
        ]);

        return response()->json([
            'message' => "Booking berhasil! Nomor antrian {$queueNum}.",
            'data'    => $this->formatAppointment($appointment->load(['poli', 'doctor.user'])),
        ], 201);
    }

    /* ════════════════════════════════════════
       INDEX — riwayat + aktif
    ════════════════════════════════════════ */

    public function index(Request $request)
    {
        $appointments = Appointment::where('user_id', $request->user()->id)
            ->with(['poli:id,name,code', 'doctor.user:id,name'])
            ->orderByDesc('appointment_date')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($a) => $this->formatAppointment($a));

        return response()->json(['data' => $appointments]);
    }

    /* ════════════════════════════════════════
       CANCEL
    ════════════════════════════════════════ */

    public function destroy(Request $request, Appointment $appointment)
    {
        if ($appointment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (in_array($appointment->status, ['completed', 'in_progress'])) {
            return response()->json(['message' => 'Antrian tidak dapat dibatalkan karena sedang diproses.'], 422);
        }

        if ($appointment->status === 'cancelled') {
            return response()->json(['message' => 'Antrian sudah dibatalkan.'], 422);
        }

        $appointment->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return response()->json(['message' => 'Antrian berhasil dibatalkan.']);
    }

    /* ════════════════════════════════════════
       HELPERS
    ════════════════════════════════════════ */

    /**
     * Resolve nomor antrian.
     * Jika user memilih slot_number spesifik, pakai itu (setelah cek belum terpakai).
     * Jika tidak, ambil nomor berikutnya secara otomatis.
     * Return null jika slot yang dipilih sudah diambil.
     */
    private function resolveQueueNumber(Poli $poli, ?int $slotNumber = null): ?string
    {
        $code = strtoupper($poli->code);

        // Jika slot spesifik dipilih user
        if ($slotNumber !== null) {
            $label = $code . '-' . str_pad($slotNumber, 3, '0', STR_PAD_LEFT);

            // Lock dan cek apakah nomor ini sudah dipakai hari ini
            $taken = DB::table('appointments')
                ->where('poli_id', $poli->id)
                ->whereDate('appointment_date', today())
                ->where('queue_number', $label)
                ->whereNotIn('status', ['cancelled', 'no_show'])
                ->lockForUpdate()
                ->exists();

            return $taken ? null : $label;
        }

        // Auto-assign: cari nomor terkecil yang belum dipakai
        $usedNumbers = DB::table('appointments')
            ->where('poli_id', $poli->id)
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->pluck('queue_number')
            ->map(function ($q) {
                $parts = explode('-', $q);
                return (int) end($parts);
            })
            ->toArray();

        for ($n = 1; $n <= 50; $n++) {
            if (!in_array($n, $usedNumbers)) {
                return $code . '-' . str_pad($n, 3, '0', STR_PAD_LEFT);
            }
        }

        return null; // penuh
    }

    /**
     * @deprecated pakai resolveQueueNumber
     */
    private function generateQueueNumber(Poli $poli): string
    {
        return $this->resolveQueueNumber($poli) ?? ($poli->code . '-FULL');
    }

    private function formatAppointment(Appointment $a): array
    {
        return [
            'id'                  => $a->id,
            'queue_number'        => $a->queue_number,
            'status'              => $a->status,
            'poli_id'             => $a->poli_id,
            'poli_name'           => $a->poli?->name,
            'poli_code'           => $a->poli?->code,
            'doctor_name'         => $a->doctor?->user?->name,
            'appointment_date'    => $a->appointment_date?->toDateString(),
            'estimated_time'      => $a->estimated_time ? substr($a->estimated_time, 0, 5) : null,
            'called_at'           => $a->called_at?->toTimeString(),
            'called_count'        => $a->called_count ?? 0,
            'is_being_called'     => $a->status === 'in_progress'
                                      && $a->called_at
                                      && $a->called_at->diffInMinutes(now()) <= 10,
        ];
    }
}
