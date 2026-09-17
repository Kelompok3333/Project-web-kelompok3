<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientProfileController extends Controller
{
    /**
     * Tampilkan profil pasien yang sedang login
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $profile = $user->patientProfile;

        return response()->json([
            'message' => 'Data profil berhasil dimuat',
            'data'    => [
                'user_id'        => $user->id,
                'name'           => $user->name,
                'email'          => $user->email,
                'profile'        => $profile ?? null,
                'is_complete'    => $this->isProfileComplete($profile),
                'needs_profile'  => !$this->isProfileComplete($profile),
            ],
        ]);
    }

    /**
     * Simpan / upsert profil pasien (POST)
     * Dipakai saat halaman /complete-profile pertama kali diisi.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nik'            => 'nullable|string|size:16|unique:patient_profiles,nik' .
                                ($user->patientProfile ? ',' . $user->patientProfile->id : ''),
            'bpjs_number'    => 'nullable|string|max:20',
            'full_name'      => 'required|string|max:255',
            'birthplace'     => 'required|string|max:100',
            'date_of_birth'  => 'required|date|before:today',
            'gender'         => 'required|in:male,female',
            'blood_type'     => 'nullable|in:A,B,AB,O',
            'address'        => 'required|string|min:10',
            'phone_number'   => 'required|string|min:10|max:15',
        ], [
            'nik.size'            => 'NIK harus tepat 16 digit.',
            'nik.unique'          => 'NIK ini sudah terdaftar.',
            'date_of_birth.before' => 'Tanggal lahir tidak valid.',
            'phone_number.min'    => 'Nomor HP minimal 10 digit.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = array_merge($validator->validated(), ['user_id' => $user->id]);

        $profile = $user->patientProfile;
        if ($profile) {
            // NIK sudah tersimpan — tidak boleh diubah setelah tersimpan pertama kali
            unset($data['nik']);
            $profile->update($data);
            $message = 'Profil berhasil diperbarui';
        } else {
            $profile = PatientProfile::create($data);
            $message = 'Profil berhasil disimpan';
        }

        return response()->json([
            'message'       => $message,
            'data'          => $profile->fresh(),
            'is_complete'   => true,
            'needs_profile' => false,
        ], $profile->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Update sebagian profil (PUT) — NIK tidak bisa diubah
     */
    public function update(Request $request)
    {
        $user    = Auth::user();
        $profile = $user->patientProfile;

        if (!$profile) {
            return response()->json([
                'message'       => 'Profil belum dibuat.',
                'needs_profile' => true,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'bpjs_number'   => 'nullable|string|max:20',
            'full_name'     => 'sometimes|required|string|max:255',
            'birthplace'    => 'sometimes|required|string|max:100',
            'date_of_birth' => 'sometimes|required|date|before:today',
            'gender'        => 'sometimes|required|in:male,female',
            'blood_type'    => 'nullable|in:A,B,AB,O',
            'address'       => 'sometimes|required|string|min:10',
            'phone_number'  => 'sometimes|required|string|min:10|max:15',
            'allergies'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $profile->update($validator->validated());

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'data'    => $profile->fresh(),
        ]);
    }

    /* ── Helper ─────────────────────────────── */
    private function isProfileComplete(?PatientProfile $profile): bool
    {
        return $profile
            && !empty($profile->nik)
            && !empty($profile->phone_number)
            && !empty($profile->full_name)
            && !empty($profile->date_of_birth);
    }
}
