<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    use HasFactory;

    protected $table = 'dependents';

    protected $fillable = [
        'employee_id',
        'name',
        'gender',
        'dob',
        'icnumber',
        'relation'
    ];

    // many to one relationship with employee
    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
