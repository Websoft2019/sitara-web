<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'week',
        'open',
        'close',
    ];

    // many to one relationship with clinic
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
