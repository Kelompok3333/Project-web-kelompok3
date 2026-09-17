<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Ringkasan dashboard admin:
     * total dokter, total petugas, total pasien, appointment hari ini
     */
    public function summary()
    {
        $today = now()->toDateString();

        $totalDoctors = Doctor::where('is_active', true)->count();

        $staffRoleId  = DB::table('roles')->where('name', 'staff')->value('id');
        $totalStaff   = User::where('role_id', $staffRoleId)->where('is_active', true)->count();

        $patientRoleId = DB::table('roles')->where('name', 'patient')->value('id');
        $totalPatients = User::where('role_id', $patientRoleId)->count();

        $todayAppointments = Appointment::whereDate('appointment_date', $today)
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->count();

        $pendingAppointments = Appointment::where('status', 'pending')->count();

        return response()->json([
            'data' => [
                'total_doctors'       => $totalDoctors,
                'total_staff'         => $totalStaff,
                'total_patients'      => $totalPatients,
                'today_appointments'  => $todayAppointments,
                'pending_appointments'=> $pendingAppointments,
            ],
        ]);
    }

    /**
     * Laporan kunjungan harian/mingguan/bulanan
     * Query params: period=daily|weekly|monthly, start_date, end_date, poli_id, doctor_id
     */
    public function visits(Request $request)
    {
        $startDate = $request->filled('start_date')
            ? $request->start_date
            : now()->subDays(30)->toDateString();

        $endDate = $request->filled('end_date')
            ? $request->end_date
            : now()->toDateString();

        $query = Appointment::whereBetween('appointment_date', [$startDate, $endDate]);

        if ($request->filled('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Agregasi per hari
        $daily = (clone $query)
            ->selectRaw('DATE(appointment_date) as date, COUNT(*) as total,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled,
                SUM(CASE WHEN status = "no_show"   THEN 1 ELSE 0 END) as no_show')
            ->groupBy(DB::raw('DATE(appointment_date)'))
            ->orderBy('date', 'asc')
            ->get();

        // Agregasi per poli
        $byPoli = (clone $query)
            ->with('poli:id,name')
            ->selectRaw('poli_id, COUNT(*) as total,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
            ->groupBy('poli_id')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [
                'poli_id'   => $row->poli_id,
                'poli_name' => $row->poli?->name ?? 'N/A',
                'total'     => $row->total,
                'completed' => $row->completed,
            ]);

        // Total keseluruhan rentang tanggal
        $totals = [
            'total'     => (clone $query)->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
            'no_show'   => (clone $query)->where('status', 'no_show')->count(),
            'pending'   => (clone $query)->where('status', 'pending')->count(),
        ];

        return response()->json([
            'data' => [
                'period'     => ['start' => $startDate, 'end' => $endDate],
                'totals'     => $totals,
                'daily'      => $daily,
                'by_poli'    => $byPoli,
            ],
        ]);
    }

    /**
     * Top dokter berdasarkan jumlah kunjungan selesai
     */
    public function topDoctors(Request $request)
    {
        $limit = $request->integer('limit', 5);
        $month = $request->filled('month') ? $request->month : now()->format('Y-m');

        [$year, $mon] = explode('-', $month);

        $doctors = Appointment::where('status', 'completed')
            ->whereYear('appointment_date', $year)
            ->whereMonth('appointment_date', $mon)
            ->select('doctor_id', DB::raw('COUNT(*) as total_visits'))
            ->groupBy('doctor_id')
            ->orderByDesc('total_visits')
            ->limit($limit)
            ->with('doctor.user:id,name')
            ->get()
            ->map(fn ($row) => [
                'doctor_id'    => $row->doctor_id,
                'doctor_name'  => $row->doctor?->user?->name ?? 'N/A',
                'total_visits' => $row->total_visits,
            ]);

        return response()->json(['data' => $doctors]);
    }
}
