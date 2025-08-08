<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'logo',
        'description',
        'commission',
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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function getEmployeesFromCompany()
    {
        return $this->hasMany(User::class, 'company_id', 'id')->where('deleted_at', null);
    }
    public function getActiveEmployeesFromCompany()
    {
        return $this->hasMany(User::class, 'company_id', 'id')->where('deleted_at', null)->where('status', 'active');
    }

    public function getCompanyClinicFromCompany()
    {
        return $this->hasMany(CompanyClinic::class, 'company_id', 'id')->where('deleted_at', null);
    }

    public function getClinicsFromCompany()
    {
        return $this->belongsToMany(Clinic::class, 'company_clinics', 'company_id', 'clinic_id')->wherePivot('deleted_at', null)->wherePivot('status', 'active');
    }
}
