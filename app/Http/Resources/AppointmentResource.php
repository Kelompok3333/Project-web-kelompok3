<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'queue_number' => $this->queue_number,
            'poli' => [
                'name' => $this->whenLoaded('poli', fn() => $this->poli->name),
                'code' => $this->whenLoaded('poli', fn() => $this->poli->code),
            ],
            'doctor' => $this->whenLoaded('doctor', function () {
                return [
                    'name' => $this->doctor->user->name,
                    'specialization' => $this->doctor->specialization,
                ];
            }),
            'appointment_date' => $this->appointment_date->format('d M Y'),
            'estimated_time' => $this->estimated_time,
            'status' => $this->status,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
