<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'nik' => $this->nik,
            'full_name' => $this->full_name,
            'date_of_birth' => $this->date_of_birth->format('d-m-Y'),
            'gender' => $this->gender === 'male' ? 'Laki-laki' : 'Perempuan',
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'blood_type' => $this->blood_type ?? '-',
            'allergies' => $this->allergies ?? 'Tidak ada',
            'notification_enabled' => (bool) $this->notification_enabled,
        ];
    }
}
