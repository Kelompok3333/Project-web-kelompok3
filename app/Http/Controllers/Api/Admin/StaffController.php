<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * Daftar semua akun petugas (staff)
     */
    public function index()
    {
        $staffRoleId = Role::where('name', 'staff')->value('id');

        $staff = User::where('role_id', $staffRoleId)
            ->latest()
            ->get()
            ->map(fn ($u) => $this->formatUser($u));

        return response()->json(['data' => $staff]);
    }

    /**
     * Tambah akun petugas baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $staffRoleId = Role::where('name', 'staff')->value('id');

        if (!$staffRoleId) {
            return response()->json(['message' => 'Role "staff" tidak ditemukan di database.'], 500);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $staffRoleId,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Akun petugas berhasil ditambahkan',
            'data'    => $this->formatUser($user),
        ], 201);
    }

    /**
     * Update data petugas (nama, email)
     */
    public function update(Request $request, User $user)
    {
        $this->ensureIsStaff($user);

        $validator = Validator::make($request->all(), [
            'name'  => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update($validator->validated());

        return response()->json([
            'message' => 'Data petugas berhasil diperbarui',
            'data'    => $this->formatUser($user->fresh()),
        ]);
    }

    /**
     * Toggle status aktif / nonaktif petugas
     */
    public function toggleActive(User $user)
    {
        $this->ensureIsStaff($user);

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json([
            'message'   => "Akun petugas berhasil {$status}",
            'is_active' => $user->is_active,
        ]);
    }

    /**
     * Reset password petugas oleh admin
     */
    public function resetPassword(Request $request, User $user)
    {
        $this->ensureIsStaff($user);

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Cabut semua token lama agar sesi lama tidak bisa dipakai
        $user->tokens()->delete();

        return response()->json(['message' => 'Password petugas berhasil direset']);
    }

    /**
     * Hapus akun petugas
     */
    public function destroy(User $user)
    {
        $this->ensureIsStaff($user);

        // Cabut semua token sebelum hapus
        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'Akun petugas berhasil dihapus']);
    }

    /* ──────────────────────────────────────
       PRIVATE HELPERS
    ────────────────────────────────────── */

    private function ensureIsStaff(User $user): void
    {
        if (!$user->isStaff()) {
            abort(403, 'User ini bukan petugas (staff).');
        }
    }

    private function formatUser(User $user): array
    {
        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'is_active'  => $user->is_active,
            'created_at' => $user->created_at?->toDateTimeString(),
        ];
    }
}
