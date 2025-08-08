<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'email' => $this->email,
            'description' => $this->description,
            'number' => $this->number,
            // 'registration_number' => $this->registration_number,
            'contact_person' => $this->contact_person,
            'contact_person_number' => $this->contact_person,
            'logo' => $this->logo ? asset('site/uploads/clinic/' . $this->logo) : null,
            'rating' => 4.3,
        ];
    }
}
