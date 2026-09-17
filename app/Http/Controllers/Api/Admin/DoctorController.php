<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Menampilkan daftar semua dokter
     */
    public function index()
    {
        $doctors = Doctor::with(['user', 'poli'])->latest()->get();
        return response()->json(['data' => $doctors]);
    }

    /**
     * Menyimpan data dokter baru + Upload Foto
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'poli_id' => 'required|exists:polis,id',
            'specialization' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bio' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        // 1. Buat Akun User untuk Dokter
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'doctor')->value('id'),
            'is_active' => true,
        ]);

        // 2. Handle Upload Foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
        }

        // 3. Simpan Data Profil Dokter
        $doctor = Doctor::create([
            'user_id' => $user->id,
            'poli_id' => $request->poli_id,
            'specialization' => $request->specialization,
            'photo' => $photoPath,
            'bio' => $request->bio,
            'experience_years' => $request->experience_years ?? 0,
        ]);

        return response()->json(['message' => 'Dokter berhasil ditambahkan', 'data' => $doctor->load(['user', 'poli'])], 201);
    }

    /**
     * Mengupdate data dokter
     * @param \App\Models\Doctor $doctor
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'specialization' => 'sometimes|required|string',
            'poli_id' => 'sometimes|required|exists:polis,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bio' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        // Update Foto jika ada file baru
        if ($request->hasFile('photo')) {
            if ($doctor->photo) Storage::disk('public')->delete($doctor->photo);
            $doctor->photo = $request->file('photo')->store('doctors', 'public');
        }

        $doctor->update($request->only(['specialization', 'poli_id', 'bio', 'experience_years', 'is_active']));

        // Update nama user jika berubah
        if ($request->has('name')) {
            $doctor->user->update(['name' => $request->name]);
        }

        return response()->json(['message' => 'Data dokter diperbarui', 'data' => $doctor->fresh(['user', 'poli'])]);
    }

    /**
     * Menghapus dokter
     * @param \App\Models\Doctor $doctor
     */
    public function destroy(Doctor $doctor)
    {
        // Hapus foto fisik dari storage
        if ($doctor->photo) Storage::disk('public')->delete($doctor->photo);

        // Hapus akun user terkait
        $doctor->user->delete();

        return response()->json(['message' => 'Dokter berhasil dihapus']);
    }
}
