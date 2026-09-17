<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'poli_id',
        'schedule_date',
        'start_time',
        'end_time',
        'max_patients',
        'is_available',
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'is_available' => 'boolean',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
