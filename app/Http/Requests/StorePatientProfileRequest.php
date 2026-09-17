<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nik' => ['required', 'string', 'size:16', 'unique:patient_profiles,nik'],
            'full_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female'],
            'address' => ['required', 'string', 'min:10'],
            'phone_number' => ['required', 'string', 'max:15'],
            'blood_type' => ['nullable', 'string', 'in:A,B,AB,O'],
            'allergies' => ['nullable', 'string', 'max:500'],
        ];
    }
}
