<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// HAPUS 'implements MustVerifyEmail' JIKA TIDAK PAKAI FITUR VERIFIKASI EMAIL
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'provider',      // Untuk social login (google/facebook)
        'provider_id',   // ID unik dari provider sosial
        'is_active',
    ];

    /**
     * Atribut yang disembunyikan saat konversi ke array/JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_id',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /* ==========================================
       RELATIONSHIPS (Hubungan Antar Tabel)
       ========================================== */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function patientProfile()
    {
        return $this->hasOne(PatientProfile::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'created_by');
    }

    public function visitHistories()
    {
        return $this->hasMany(VisitHistory::class);
    }

    /* ==========================================
       HELPER METHODS (Cek Role User)
       ========================================== */

    public function isPatient(): bool
    {
        return $this->role && $this->role->name === 'patient';
    }

    public function isStaff(): bool
    {
        return $this->role && $this->role->name === 'staff';
    }

    public function isDoctor(): bool
    {
        return $this->role && $this->role->name === 'doctor';
    }

    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'admin';
    }
}
