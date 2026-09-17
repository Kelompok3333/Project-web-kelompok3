<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'poli_id' => ['required', 'exists:polis,id,is_active,1'],
            'doctor_schedule_id' => ['required', 'exists:doctor_schedules,id,is_available,1'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}
