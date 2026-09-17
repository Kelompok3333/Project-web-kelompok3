<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $polis = [
            [
                'name' => 'Poli Umum',
                'code' => 'UMUM',
                'description' => 'Layanan pemeriksaan umum dan konsultasi kesehatan dasar',
                'max_queue_per_day' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Poli Gigi',
                'code' => 'GIGI',
                'description' => 'Layanan kesehatan gigi dan mulut',
                'max_queue_per_day' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Poli Anak',
                'code' => 'ANAK',
                'description' => 'Layanan kesehatan khusus anak-anak',
                'max_queue_per_day' => 40,
                'is_active' => true,
            ],
        ];

        foreach ($polis as $poli) {
            DB::table('polis')->updateOrInsert(
                ['code' => $poli['code']],
                [
                    'name' => $poli['name'],
                    'description' => $poli['description'],
                    'max_queue_per_day' => $poli['max_queue_per_day'],
                    'is_active' => $poli['is_active'],
                ],
            );
        }
    }
}
