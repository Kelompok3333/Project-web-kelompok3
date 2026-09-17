<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Sistem Pemanggilan Nomor Antrian
 *
 * Flow status:
 *   arrived  →  [call]  →  in_progress  →  [complete] →  completed
 *                           in_progress  →  [skip]     →  no_show
 *   in_progress →  [recall] tetap in_progress, called_count++
 *
 * Papan "board" adalah state terakhir yang di-broadcast ke semua klien
 * via polling GET /api/admin/queue/board (tanpa WebSocket/Pusher).
 */
class QueueCallController extends Controller
{
    /* ─────────────────────────────────────────────
       1. BOARD  — status terkini semua poli hari ini
    ───────────────────────────────────────────── */

    /**
     * GET /api/admin/queue/board?poli_id=
     * Dipakai oleh papan TV, panel admin, dan pasien (polling tiap 4 detik).
     */
    public function board(Request $request)
    {
        $poliId = $request->query('poli_id');

        $query = Appointment::with(['poli:id,name,code', 'user:id,name', 'user.patientProfile:user_id,full_name'])
            ->whereDate('appointment_date', today());

        if ($poliId) {
            $query->where('poli_id', $poliId);
        }

        // "Sedang dipanggil / dilayani" — in_progress per poli
        $serving = (clone $query)
            ->where('status', 'in_progress')
            ->orderByDesc('called_at')
            ->get()
            ->groupBy('poli_id')
            ->map(fn ($g) => $g->first());

        // "Terakhir dipanggil" — snapshot nomor terakhir yang dipanggil (sudah selesai pun)
        $lastCalled = (clone $query)
            ->whereNotNull('called_at')
            ->orderByDesc('called_at')
            ->get()
            ->groupBy('poli_id')
            ->map(fn ($g) => $g->first());

        // Antrian menunggu
        $waiting = (clone $query)
            ->whereIn('status', ['arrived'])
            ->orderBy('queue_number')
            ->get()
            ->groupBy('poli_id');

        // Semua poli aktif hari ini
        $polis = Poli::where('is_active', true)->get(['id', 'name', 'code']);

        $board = $polis->map(function ($poli) use ($serving, $lastCalled, $waiting) {
            $s = $serving->get($poli->id);
            $l = $lastCalled->get($poli->id);
            $w = $waiting->get($poli->id, collect());

            return [
                'poli_id'      => $poli->id,
                'poli_name'    => $poli->name,
                'poli_code'    => $poli->code,
                'now_serving'  => $s ? [
                    'appointment_id'     => $s->id,
                    'queue_number'       => $s->queue_number,
                    'call_display_number'=> $s->call_display_number,
                    'patient_name'       => $s->user->patientProfile->full_name ?? $s->user->name,
                    'called_at'          => $s->called_at?->toTimeString(),
                    'called_count'       => $s->called_count,
                ] : null,
                'last_called'  => $l && $l->id !== ($s?->id) ? [
                    'queue_number' => $l->queue_number,
                    'patient_name' => $l->user->patientProfile->full_name ?? $l->user->name,
                ] : null,
                'waiting_count'=> $w->count(),
                'waiting_list' => $w->map(fn ($a) => [
                    'appointment_id' => $a->id,
                    'queue_number'   => $a->queue_number,
                    'patient_name'   => $a->user->patientProfile->full_name ?? $a->user->name,
                    'estimated_time' => $a->estimated_time,
                ])->values(),
            ];
        })->values();

        return response()->json([
            'timestamp' => now()->toDateTimeString(),
            'data'      => $board,
        ]);
    }

    /* ─────────────────────────────────────────────
       2. STATUS PASIEN — untuk polling di HP pasien
    ───────────────────────────────────────────── */

    /**
     * GET /api/queue/my-status
     * Pasien poll ini tiap 4 detik untuk cek apakah nomornya dipanggil.
     */
    public function myStatus(Request $request)
    {
        $user = $request->user();

        $appointment = Appointment::where('user_id', $user->id)
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['completed', 'cancelled', 'no_show'])
            ->with(['poli:id,name,code', 'doctor.user:id,name'])
            ->orderByDesc('created_at')
            ->first();

        if (!$appointment) {
            return response()->json(['data' => null]);
        }

        // Berapa orang arrived yang antri sebelum saya
        $ahead = Appointment::where('poli_id', $appointment->poli_id)
            ->whereDate('appointment_date', today())
            ->where('status', 'arrived')
            ->where('queue_number', '<', $appointment->queue_number)
            ->count();

        // Nomor yang sedang dipanggil di poli ini
        $nowServing = Appointment::where('poli_id', $appointment->poli_id)
            ->whereDate('appointment_date', today())
            ->where('status', 'in_progress')
            ->orderByDesc('called_at')
            ->value('queue_number');

        return response()->json([
            'data' => [
                'appointment_id'      => $appointment->id,
                'queue_number'        => $appointment->queue_number,
                'call_display_number' => $appointment->call_display_number,
                'status'              => $appointment->status,
                'poli_name'           => $appointment->poli->name,
                'poli_code'           => $appointment->poli->code,
                'doctor_name'         => $appointment->doctor?->user?->name,
                'appointment_date'    => $appointment->appointment_date->toDateString(),
                'estimated_time'      => $appointment->estimated_time,
                'called_at'           => $appointment->called_at?->toDateTimeString(),
                'called_count'        => $appointment->called_count,
                'is_being_called'     => $appointment->status === 'in_progress'
                                         && $appointment->called_at
                                         && $appointment->called_at->diffInMinutes(now()) <= 10,
                'people_ahead'        => $ahead,
                'now_serving'         => $nowServing,
            ],
        ]);
    }

    /* ─────────────────────────────────────────────
       3. AKSI ADMIN
    ───────────────────────────────────────────── */

    /**
     * GET /api/admin/queue/list?poli_id=
     * Daftar antrian hari ini untuk panel admin (per poli, status arrived).
     */
    public function list(Request $request)
    {
        $request->validate(['poli_id' => 'required|exists:polis,id']);

        $items = Appointment::with(['user:id,name', 'user.patientProfile:user_id,full_name,phone_number'])
            ->whereDate('appointment_date', today())
            ->where('poli_id', $request->poli_id)
            ->whereIn('status', ['arrived', 'in_progress'])
            ->orderBy('queue_number')
            ->get()
            ->map(fn ($a) => [
                'appointment_id'  => $a->id,
                'queue_number'    => $a->queue_number,
                'patient_name'    => $a->user->patientProfile->full_name ?? $a->user->name,
                'status'          => $a->status,
                'called_count'    => $a->called_count,
                'called_at'       => $a->called_at?->toTimeString(),
                'estimated_time'  => $a->estimated_time,
            ]);

        return response()->json(['data' => $items]);
    }

    /**
     * POST /api/admin/queue/{appointment}/call
     * Panggil nomor antrian (pertama kali).
     */
    public function call(Request $request, Appointment $appointment)
    {
        if (!in_array($appointment->status, ['arrived', 'in_progress'])) {
            return response()->json(['message' => 'Pasien belum arrived atau sudah selesai.'], 422);
        }

        $appointment->update([
            'status'              => 'in_progress',
            'called_at'           => now(),
            'called_count'        => $appointment->called_count + 1,
            'call_display_number' => $appointment->queue_number,
        ]);

        return response()->json([
            'message' => 'Nomor ' . $appointment->queue_number . ' berhasil dipanggil.',
            'data'    => $this->appointmentSummary($appointment->fresh()),
        ]);
    }

    /**
     * POST /api/admin/queue/{appointment}/recall
     * Ulangi panggilan (pasien tidak muncul, panggil lagi).
     */
    public function recall(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'in_progress') {
            return response()->json(['message' => 'Tidak ada panggilan aktif untuk nomor ini.'], 422);
        }

        $appointment->update([
            'called_at'    => now(),
            'called_count' => $appointment->called_count + 1,
        ]);

        return response()->json([
            'message' => 'Panggilan ulang untuk ' . $appointment->queue_number,
            'data'    => $this->appointmentSummary($appointment->fresh()),
        ]);
    }

    /**
     * POST /api/admin/queue/{appointment}/complete
     * Pasien selesai dilayani → status completed.
     */
    public function complete(Appointment $appointment)
    {
        if ($appointment->status !== 'in_progress') {
            return response()->json(['message' => 'Pasien tidak sedang in_progress.'], 422);
        }

        $appointment->update([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);

        return response()->json(['message' => 'Pasien ' . $appointment->queue_number . ' selesai dilayani.']);
    }

    /**
     * POST /api/admin/queue/{appointment}/skip
     * Lewati pasien → status no_show.
     */
    public function skip(Appointment $appointment)
    {
        if (!in_array($appointment->status, ['arrived', 'in_progress'])) {
            return response()->json(['message' => 'Status tidak valid untuk dilewati.'], 422);
        }

        $appointment->update(['status' => 'no_show']);

        return response()->json(['message' => 'Pasien ' . $appointment->queue_number . ' dilewati (no show).']);
    }

    /**
     * POST /api/admin/queue/{appointment}/reset
     * Kembalikan status in_progress → arrived (batal panggilan).
     */
    public function reset(Appointment $appointment)
    {
        if ($appointment->status !== 'in_progress') {
            return response()->json(['message' => 'Tidak ada panggilan aktif.'], 422);
        }

        $appointment->update(['status' => 'arrived']);

        return response()->json(['message' => 'Panggilan dibatalkan, pasien kembali ke antrian.']);
    }

    /* ─────────────────────────────────────────────
       PRIVATE
    ───────────────────────────────────────────── */

    private function appointmentSummary(Appointment $a): array
    {
        return [
            'appointment_id'      => $a->id,
            'queue_number'        => $a->queue_number,
            'call_display_number' => $a->call_display_number,
            'patient_name'        => $a->user->patientProfile->full_name ?? $a->user->name,
            'status'              => $a->status,
            'called_at'           => $a->called_at?->toTimeString(),
            'called_count'        => $a->called_count,
        ];
    }
}
