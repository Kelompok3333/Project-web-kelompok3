<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;

/**
 * Controller publik — dipakai route GET /api/doctors (tanpa login)
 * untuk menampilkan daftar dokter di halaman publik.
 */
class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['user:id,name', 'poli:id,name'])
            ->where('is_active', true)
            ->latest()
            ->get()
            ->map(fn ($d) => [
                'id'               => $d->id,
                'name'             => $d->user?->name,
                'specialization'   => $d->specialization,
                'poli'             => $d->poli?->name,
                'bio'              => $d->bio,
                'experience_years' => $d->experience_years,
                'photo'            => $d->photo ? asset('storage/' . $d->photo) : null,
            ]);

        return response()->json(['data' => $doctors]);
    }
}
