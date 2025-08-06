<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyClinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'company_id',
        'refer_code'
    ];

    public function getCompanyFromCompanyClinic(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    
    public function getClinicFromCompanyClinic(){
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }
}
