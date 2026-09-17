<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'user_id',
        'doctor_id',
        'poli_id',
        'visit_date',
        'symptoms',
        'diagnosis',
        'treatment',
        'prescription',
        'notes',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
