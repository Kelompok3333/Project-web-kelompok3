<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('poli_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('doctor_schedule_id')->nullable()->constrained()->onDelete('set null');
            $table->date('appointment_date');
            $table->time('estimated_time')->nullable();
            $table->string('queue_number');
            $table->enum('status', [
                'pending',
                'confirmed',
                'arrived',
                'in_progress',
                'completed',
                'cancelled',
                'no_show'
            ])->default('pending');
            $table->text('cancel_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('arrived_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'appointment_date']);
            $table->index(['poli_id', 'appointment_date']);
            $table->index(['doctor_id', 'appointment_date']);
            $table->unique(['poli_id', 'appointment_date', 'queue_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
