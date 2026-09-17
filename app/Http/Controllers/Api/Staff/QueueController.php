<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $poliId = $request->query('poli_id');
        $query = Appointment::with(['user.patientProfile', 'doctor.user'])
            ->whereDate('appointment_date', today())
            ->whereIn('status', ['pending', 'confirmed', 'arrived', 'in_progress']);

        if ($poliId) $query->where('poli_id', $poliId);

        $queues = $query->orderBy('queue_number')->get()->groupBy(function ($item) {
            return $item->poli?->name ?? 'Unknown';
        });

        return response()->json($queues);
    }

    public function verify(Request $request)
    {
        $request->validate(['appointment_id' => 'required|exists:appointments,id']);
        $appointment = Appointment::findOrFail($request->appointment_id);

        if ($appointment->status === 'arrived') {
            return response()->json(['message' => 'Sudah diverifikasi'], 409);
        }

        $appointment->update(['status' => 'arrived', 'arrived_at' => now()]);
        return response()->json(['message' => 'Diverifikasi', 'data' => $appointment->load('user.patientProfile')]);
    }

    public function storeWalkIn(Request $request)
    {
        $validated = $request->validate([
            'poli_id' => 'required|exists:polis,id',
            'nik' => 'nullable|string|size:16',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'is_emergency' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $user = null;
            if (!empty($validated['nik'])) {
                $profile = PatientProfile::where('nik', $validated['nik'])->first();
                $user = $profile?->user;
            }

            if (!$user && !empty($validated['phone_number'])) {
                $profile = PatientProfile::where('phone_number', $validated['phone_number'])->first();
                $user = $profile?->user;
            }

            if (!$user) {
                $user = User::create([
                    'name' => $validated['full_name'],
                    'email' => 'walkin_' . time() . '@klinik.local',
                    'password' => Hash::make(str()->random(32)),
                    'role_id' => DB::table('roles')->where('name', 'patient')->value('id'),
                    'is_active' => true,
                ]);

                PatientProfile::create([
                    'user_id' => $user->id,
                    'nik' => $validated['nik'] ?? '0000000000000000',
                    'full_name' => $validated['full_name'],
                    'date_of_birth' => '2000-01-01',
                    'gender' => 'male',
                    'address' => '-',
                    'phone_number' => $validated['phone_number'],
                ]);
            }

            $poliCode = DB::table('polis')->where('id', $validated['poli_id'])->value('code');
            $currentCount = Appointment::where('poli_id', $validated['poli_id'])
                ->whereDate('appointment_date', today())->count();

            $queueNum = 'W-' . $poliCode . '-' . str_pad($currentCount + 1, 3, '0', STR_PAD_LEFT);

            $appointment = Appointment::create([
                'user_id' => $user->id,
                'poli_id' => $validated['poli_id'],
                'appointment_date' => today(),
                'queue_number' => $queueNum,
                'status' => $validated['is_emergency'] ? 'arrived' : 'pending',
                'arrived_at' => $validated['is_emergency'] ? now() : null,
            ]);

            DB::commit();
            return response()->json(['message' => 'Walk-in berhasil', 'data' => $appointment->load('user.patientProfile')], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
}
