<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'total_amount',
        'company_claim_amount',
        'paid_amount',
    ];

    public function getAppointmentFromPayment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }
}
