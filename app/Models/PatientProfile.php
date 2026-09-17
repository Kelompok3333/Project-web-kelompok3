<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'bpjs_number',
        'birthplace',
        'full_name',
        'date_of_birth',
        'gender',
        'address',
        'phone_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        'blood_type',
        'allergies',
        'medical_history',
        'notification_enabled',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'notification_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasManyThrough(Appointment::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
}
