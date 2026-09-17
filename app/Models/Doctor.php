<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'poli_id',
        'specialization',
        'photo',
        'bio',
        'education',
        'experience_years',
        'is_active'
    ];

    // Dokter milik satu user (akun login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Dokter berada di satu poli
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    // Dokter punya banyak jadwal
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    // Dokter punya banyak appointment
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
