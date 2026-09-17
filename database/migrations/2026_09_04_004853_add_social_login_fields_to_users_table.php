<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom role_id setelah id
            $table->foreignId('role_id')->nullable()->after('id');

            // Tambah kolom untuk social login
            $table->string('provider')->nullable()->after('email');
            $table->string('provider_id')->nullable()->after('provider');

            // Tambah kolom status aktif
            $table->boolean('is_active')->default(true)->after('email_verified_at');

            // Foreign key constraint
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['role_id']);

            // Hapus semua kolom yang ditambahkan
            $table->dropColumn([
                'role_id',
                'provider',
                'provider_id',
                'is_active'
            ]);
        });
    }
};
