<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID role admin
        $adminRoleId = DB::table('roles')->where('name', 'admin')->first()?->id;

        if (!$adminRoleId) {
            $this->command->error('Role admin tidak ditemukan! Jalankan RoleSeeder dulu.');
            return;
        }

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@medika.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRoleId,
                'is_active' => true,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ],
        );
    }
}
