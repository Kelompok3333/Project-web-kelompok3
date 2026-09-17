<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Ringkasan dashboard pasien:
     * - Appointment aktif (pending/confirmed)
     * - Riwayat kunjungan terakhir
     * - Notifikasi belum dibaca
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Appointment aktif (pending / confirmed)
        $activeAppointments = Appointment::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'arrived', 'in_progress'])
            ->with(['poli', 'doctor.user', 'doctorSchedule'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        // 5 riwayat kunjungan terakhir
        $recentHistory = Appointment::where('user_id', $user->id)
            ->whereIn('status', ['completed'])
            ->with(['poli', 'doctor.user'])
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        // Jumlah notifikasi belum dibaca
        $unreadNotifications = $user->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json([
            'message' => 'Dashboard pasien berhasil dimuat',
            'data' => [
                'user' => [
                    'id'     => $user->id,
                    'name'   => $user->name,
                    'email'  => $user->email,
                    'profile_complete' => $user->patientProfile
                        && !empty($user->patientProfile->nik)
                        && !empty($user->patientProfile->phone),
                ],
                'active_appointments'    => $activeAppointments,
                'recent_history'         => $recentHistory,
                'unread_notifications'   => $unreadNotifications,
            ],
        ]);
    }
}
