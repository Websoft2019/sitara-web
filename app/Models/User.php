<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'company_id',
        'first_name',
        'middle_name',
        'last_name',
        'image',
        'post',
        'date_of_birth',
        'gender',
        'race',
        'ic_number',
        'phone_number',
        'address',
        'description',
        'per_visit_claim',
        'email_verified_at',
        'status',
        'is_first_login',
        'deleted_at',
        'email',
        'password',
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
        'date_of_birth' => 'date'
    ];

    public function getCompanyFromUser()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    // one to many relationship with dependent
    public function getDependent()
    {
        return $this->hasMany(Dependent::class, 'employee_id', 'id');
    }
}
