<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'patient', 'description' => 'Pasien Klinik'],
            ['name' => 'staff', 'description' => 'Petugas Klinik'],
            ['name' => 'doctor', 'description' => 'Dokter'],
            ['name' => 'admin', 'description' => 'Administrator'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                ['description' => $role['description'], 'updated_at' => now(), 'created_at' => now()],
            );
        }
    }
}
