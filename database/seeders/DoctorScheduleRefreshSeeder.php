<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Buat / refresh jadwal praktik untuk hari ini, besok, dan lusa.
 * Aman dijalankan berulang (updateOrInsert).
 *
 * php artisan db:seed --class=DoctorScheduleRefreshSeeder
 */
class DoctorScheduleRefreshSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = DB::table('doctors')
            ->where('is_active', true)
            ->get();

        if ($doctors->isEmpty()) {
            $this->command->warn('Tidak ada dokter aktif — jalankan DoctorSeeder terlebih dahulu.');
            return;
        }

        $days = [
            now()->toDateString(),
            now()->addDay()->toDateString(),
            now()->addDays(2)->toDateString(),
        ];

        // Slot waktu default per sesi
        $slots = [
            ['start' => '08:00:00', 'end' => '12:00:00'],
            ['start' => '13:00:00', 'end' => '17:00:00'],
        ];

        $inserted = 0;

        foreach ($doctors as $doc) {
            foreach ($days as $i => $date) {
                // Setiap dokter dapat 1 slot per hari, bergantian pagi/sore
                $slot = $slots[$i % 2];

                // updateOrInsert berdasarkan (doctor_id + date) agar aman dijalankan ulang
                $exists = DB::table('doctor_schedules')
                    ->where('doctor_id', $doc->id)
                    ->where('schedule_date', $date)
                    ->exists();

                if (!$exists) {
                    DB::table('doctor_schedules')->insert([
                        'doctor_id'     => $doc->id,
                        'poli_id'       => $doc->poli_id,
                        'schedule_date' => $date,
                        'start_time'    => $slot['start'],
                        'end_time'      => $slot['end'],
                        'max_patients'  => 20,
                        'is_available'  => true,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);
                    $inserted++;
                }
            }
        }

        $this->command->info("Selesai — {$inserted} jadwal baru dibuat untuk {$doctors->count()} dokter.");
    }
}
