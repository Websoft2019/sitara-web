<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Company\CompanyForUser as CompanyForUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
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
            'employee_id' => $this->employee_id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'image' => $this->image ? asset('site/uploads/company/employee/' . $this->image) : null,
            'post' => $this->post,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'race' => $this->race,
            'ic_number' => $this->ic_number,
            'phone_number' => $this->phone_number != null ? $this->phone_number : '',
            'address' => $this->address,
            'description' => $this->description != null ? $this->description : '',
            'per_visit_claim' => $this->per_visit_claim,
            'email' => $this->email != null ? $this->email : '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'company' => new CompanyForUserResource($this->getCompanyFromUser)
        ];
    }
}
