<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'poli_id',
        'doctor_id',
        'doctor_schedule_id',
        'appointment_date',
        'estimated_time',
        'queue_number',
        'temp_phone',
        'status',
        'cancel_reason',
        'cancelled_at',
        'arrived_at',
        'completed_at',
        'called_at',
        'called_count',
        'call_display_number',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'cancelled_at'     => 'datetime',
        'arrived_at'       => 'datetime',
        'completed_at'     => 'datetime',
        'called_at'        => 'datetime',
        'called_count'     => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function doctorSchedule()
    {
        return $this->belongsTo(DoctorSchedule::class);
    }

    public function visitHistory()
    {
        return $this->hasOne(VisitHistory::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
