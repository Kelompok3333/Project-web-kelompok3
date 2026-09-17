<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom KIS/BPJS ke tabel patient_profiles:
 *   - bpjs_number : Nomor Kartu Indonesia Sehat (opsional)
 *   - birthplace  : Tempat lahir (wajib sesuai KTP)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->string('bpjs_number', 20)->nullable()->after('nik');
            $table->string('birthplace', 100)->nullable()->after('bpjs_number');
        });
    }

    public function down(): void
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->dropColumn(['bpjs_number', 'birthplace']);
        });
    }
};
