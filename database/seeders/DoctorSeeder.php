<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari ID Role 'doctor'
        $doctorRoleId = DB::table('roles')->where('name', 'doctor')->first()?->id;
        if (!$doctorRoleId) return;

        // 2. Cari ID Poli 'Poli Umum' (id=1 biasanya)
        $poliId = DB::table('polis')->where('code', 'UMUM')->first()?->id;
        if (!$poliId) return;

        // 3. Buat User untuk Dokter
        $userId = DB::table('users')->insertGetId([
            'name' => 'Dr. Budi Santoso',
            'email' => 'dokter@medika.com',
            'password' => Hash::make('dokter123'),
            'role_id' => $doctorRoleId,
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Buat Data Dokter
        $doctorId = DB::table('doctors')->insertGetId([
            'user_id' => $userId,
            'poli_id' => $poliId,
            'specialization' => 'Dokter Umum',
            'education' => 'FKUI',
            'experience_years' => 10,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Buat Jadwal Praktik (Hari ini & Besok)
        $today = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');

        DB::table('doctor_schedules')->insert([
            [
                'doctor_id' => $doctorId,
                'poli_id' => $poliId,
                'schedule_date' => $today,
                'start_time' => '08:00:00',
                'end_time' => '12:00:00',
                'max_patients' => 20,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id' => $doctorId,
                'poli_id' => $poliId,
                'schedule_date' => $tomorrow,
                'start_time' => '13:00:00',
                'end_time' => '17:00:00',
                'max_patients' => 20,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
