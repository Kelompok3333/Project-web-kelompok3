<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorScheduleController extends Controller
{
    /**
     * Daftar semua jadwal (opsional filter by doctor_id atau poli_id)
     */
    public function index(Request $request)
    {
        $query = DoctorSchedule::with(['doctor.user:id,name', 'doctor.poli:id,name', 'poli:id,name'])
            ->orderBy('schedule_date', 'asc')
            ->orderBy('start_time', 'asc');

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('schedule_date', $request->date);
        }

        return response()->json(['data' => $query->get()->map(fn ($s) => $this->formatSchedule($s))]);
    }

    /**
     * Tambah jadwal baru untuk dokter
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id'     => 'required|exists:doctors,id',
            'poli_id'       => 'required|exists:polis,id',
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i|after:start_time',
            'max_patients'  => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cek dokter sesuai poli
        $doctor = Doctor::find($request->doctor_id);
        if ((int) $doctor->poli_id !== (int) $request->poli_id) {
            return response()->json([
                'message' => 'Dokter ini tidak bertugas di poli yang dipilih.',
            ], 422);
        }

        // Cek jadwal bertabrakan (dokter + tanggal + waktu overlap)
        $conflict = DoctorSchedule::where('doctor_id', $request->doctor_id)
            ->where('schedule_date', $request->schedule_date)
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('start_time', '<=', $request->start_time)
                         ->where('end_time', '>=', $request->end_time);
                  });
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'message' => 'Jadwal dokter bertabrakan dengan jadwal yang sudah ada.',
            ], 422);
        }

        $schedule = DoctorSchedule::create([
            'doctor_id'     => $request->doctor_id,
            'poli_id'       => $request->poli_id,
            'schedule_date' => $request->schedule_date,
            'start_time'    => $request->start_time . ':00',
            'end_time'      => $request->end_time . ':00',
            'max_patients'  => $request->max_patients,
            'is_available'  => true,
        ]);

        return response()->json([
            'message' => 'Jadwal berhasil ditambahkan',
            'data'    => $this->formatSchedule($schedule->load(['doctor.user:id,name', 'poli:id,name'])),
        ], 201);
    }

    /**
     * Update jadwal (admin bisa ubah waktu, kuota, atau toggle ketersediaan)
     */
    public function update(Request $request, DoctorSchedule $doctorSchedule)
    {
        $validator = Validator::make($request->all(), [
            'schedule_date' => 'sometimes|required|date',
            'start_time'    => 'sometimes|required|date_format:H:i',
            'end_time'      => 'sometimes|required|date_format:H:i',
            'max_patients'  => 'sometimes|required|integer|min:1|max:100',
            'is_available'  => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Normalisasi format waktu
        if (isset($data['start_time']) && strlen($data['start_time']) === 5) {
            $data['start_time'] .= ':00';
        }
        if (isset($data['end_time']) && strlen($data['end_time']) === 5) {
            $data['end_time'] .= ':00';
        }

        $doctorSchedule->update($data);

        return response()->json([
            'message' => 'Jadwal berhasil diperbarui',
            'data'    => $this->formatSchedule(
                $doctorSchedule->fresh(['doctor.user:id,name', 'poli:id,name'])
            ),
        ]);
    }

    /**
     * Hapus jadwal
     */
    public function destroy(DoctorSchedule $doctorSchedule)
    {
        // Cek apakah ada appointment aktif yang terkait
        $hasActive = $doctorSchedule->appointments()
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->exists();

        if ($hasActive) {
            return response()->json([
                'message' => 'Jadwal tidak dapat dihapus karena masih ada appointment aktif.',
            ], 422);
        }

        $doctorSchedule->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }

    /* ──────────────────────────────────────
       PRIVATE HELPERS
    ────────────────────────────────────── */

    private function formatSchedule(DoctorSchedule $s): array
    {
        return [
            'id'            => $s->id,
            'doctor_id'     => $s->doctor_id,
            'doctor_name'   => $s->doctor?->user?->name,
            'poli_id'       => $s->poli_id,
            'poli_name'     => $s->poli?->name,
            'schedule_date' => $s->schedule_date instanceof \Carbon\Carbon
                ? $s->schedule_date->toDateString()
                : $s->schedule_date,
            'start_time'    => substr($s->start_time ?? '', 0, 5),
            'end_time'      => substr($s->end_time ?? '', 0, 5),
            'max_patients'  => $s->max_patients,
            'is_available'  => (bool) $s->is_available,
        ];
    }
}
