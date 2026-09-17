<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom temp_phone ke tabel appointments.
 * Dipakai sebagai backup kontak saat pasien booking
 * sebelum profil lengkap terisi.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('temp_phone', 15)->nullable()->after('queue_number');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('temp_phone');
        });
    }
};
