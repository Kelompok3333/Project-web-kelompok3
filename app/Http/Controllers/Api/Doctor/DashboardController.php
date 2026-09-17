<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\VisitHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $doctor = $request->user()->doctor;
        if (!$doctor) return response()->json(['message' => 'Akun dokter tidak ditemukan'], 404);

        $queues = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->where('status', 'arrived')
            ->with('user.patientProfile')
            ->orderBy('queue_number')
            ->get();

        return response()->json($queues);
    }

    public function startExam(Request $request, Appointment $appointment)
    {
        if ($appointment->doctor_id !== $request->user()->doctor->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if ($appointment->status !== 'arrived') {
            return response()->json(['message' => 'Pasien belum arrived'], 422);
        }

        $appointment->update(['status' => 'in_progress']);
        return response()->json(['message' => 'Pemeriksaan dimulai', 'data' => $appointment]);
    }

    public function finishExam(Request $request, Appointment $appointment)
    {
        if ($appointment->doctor_id !== $request->user()->doctor->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'symptoms' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment->update(['status' => 'completed', 'completed_at' => now()]);

        VisitHistory::create(array_merge($validated, [
            'appointment_id' => $appointment->id,
            'user_id' => $appointment->user_id,
            'doctor_id' => $appointment->doctor_id,
            'poli_id' => $appointment->poli_id,
            'visit_date' => today(),
        ]));

        return response()->json(['message' => 'Selesai & rekam medis tersimpan']);
    }
}
