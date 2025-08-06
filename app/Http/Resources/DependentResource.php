<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DependentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
{
    return [
        'id' => $this->id, // You can include this if needed
        'employee_id' => $this->employee_id,
        'name' => $this->name,
        'dob' => $this->dob, // Ensure you're accessing the 'dob' attribute properly
        'icnumber' => $this->icnumber,
        'relation' => $this->relation,
        'photo' => $this->photo ? asset('site/uploads/dependent/' . $this->photo) : asset('site/assets/img/logo.png'), // Corrected asset path generation
        'status' => $this->status,
        'min_benefit' => $this->min_benefit,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
    ];
}

}
