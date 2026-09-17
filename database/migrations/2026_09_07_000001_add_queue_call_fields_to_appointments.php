<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Kapan terakhir dipanggil oleh admin/petugas
            $table->timestamp('called_at')->nullable()->after('arrived_at');
            // Berapa kali dipanggil (untuk "Ulang Panggil")
            $table->unsignedTinyInteger('called_count')->default(0)->after('called_at');
            // Nomor urut panggilan di papan (nomor yang tampil di layar TV)
            $table->string('call_display_number', 20)->nullable()->after('called_count');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['called_at', 'called_count', 'call_display_number']);
        });
    }
};
