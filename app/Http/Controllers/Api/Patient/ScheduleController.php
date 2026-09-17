<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\Poli;
use Illuminate\Http\Request;

/**
 * Endpoint untuk pasien mencari jadwal tersedia sebelum booking.
 */
class ScheduleController extends Controller
{
    /**
     * GET /api/schedules?poli_id=&date=
     * Kembalikan jadwal dokter yang tersedia untuk poli + tanggal tertentu,
     * lengkap dengan sisa kuota.
     */
    public function index(Request $request)
    {
        $request->validate([
            'poli_id' => 'required|exists:polis,id',
            'date'    => 'required|date|after_or_equal:today',
        ]);

        $schedules = DoctorSchedule::with(['doctor.user:id,name', 'doctor:id,user_id,specialization,photo'])
            ->where('poli_id', $request->poli_id)
            ->where('schedule_date', $request->date)
            ->where('is_available', true)
            ->get()
            ->map(function ($s) {
                // Hitung sisa kuota
                $booked = Appointment::where('doctor_schedule_id', $s->id)
                    ->whereNotIn('status', ['cancelled', 'no_show'])
                    ->count();

                $remaining = max(0, $s->max_patients - $booked);

                return [
                    'id'             => $s->id,
                    'doctor_id'      => $s->doctor_id,
                    'doctor_name'    => $s->doctor?->user?->name,
                    'specialization' => $s->doctor?->specialization,
                    'doctor_photo'   => $s->doctor?->photo
                        ? asset('storage/' . $s->doctor->photo) : null,
                    'poli_id'        => $s->poli_id,
                    'schedule_date'  => $s->schedule_date instanceof \Carbon\Carbon
                        ? $s->schedule_date->toDateString()
                        : $s->schedule_date,
                    'start_time'     => substr($s->start_time ?? '', 0, 5),
                    'end_time'       => substr($s->end_time ?? '', 0, 5),
                    'max_patients'   => $s->max_patients,
                    'booked'         => $booked,
                    'remaining'      => $remaining,
                    'is_full'        => $remaining === 0,
                ];
            });

        return response()->json(['data' => $schedules]);
    }

    /**
     * GET /api/schedules/available-dates?poli_id=
     * Kembalikan daftar tanggal yang masih ada jadwal tersedia (30 hari ke depan).
     * Berguna untuk disable tanggal di date-picker pasien.
     */
    public function availableDates(Request $request)
    {
        $request->validate(['poli_id' => 'required|exists:polis,id']);

        $dates = DoctorSchedule::where('poli_id', $request->poli_id)
            ->where('is_available', true)
            ->where('schedule_date', '>=', today())
            ->where('schedule_date', '<=', today()->addDays(30))
            ->pluck('schedule_date')
            ->map(fn ($d) => $d instanceof \Carbon\Carbon ? $d->toDateString() : $d)
            ->unique()
            ->values();

        return response()->json(['data' => $dates]);
    }
}
