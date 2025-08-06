<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'slug',
        'logo',
        'description',
        'registration_number',
        'contact_person',
        'contact_person_number',
        'number',
        'address',
        'longitude',
        'latitude',
        'is_first_login',
        'email_verified_at',
        'status',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getUserFromClinic()
    {
        return $this->hasMany(ClinicUser::class, 'clinic_id', 'id')->where('deleted_at', null);
    }

    public function getCompanyClinicFromClinic()
    {
        return $this->hasMany(CompanyClinic::class, 'clinic_id', 'id')->where('deleted_at', null)->where('status', 'active');
    }

    public function getCompaniesFromClinics()
    {
        return $this->belongsToMany(Company::class, 'company_clinics', 'company_id', 'clinic_id')->wherePivot('deleted_at', null)->wherePivot('status', 'active');
    }

    public function distanceTo($latitude, $longitude)
    {
        $earthRadius = 6371; // in km

        $latDiff = deg2rad($latitude - $this->latitude);
        $lonDiff = deg2rad($longitude - $this->longitude);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos(deg2rad($this->latitude)) * cos(deg2rad($latitude)) *
            sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }

    // one to many relationship with clinicshecdule
    public function clinicSchedules()
    {
        return $this->hasMany(ClinicSchedule::class, 'clinic_id', 'id');
    }
    
}
