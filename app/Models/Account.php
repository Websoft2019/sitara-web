<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'title',
        'amount',
    ];

    public function getAppointmentFromAccount()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }
}
