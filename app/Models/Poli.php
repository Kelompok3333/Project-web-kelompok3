<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'max_queue_per_day',
        'is_active'
    ];

    // Satu poli punya banyak dokter
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    // Satu poli punya banyak jadwal
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
