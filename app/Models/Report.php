<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_type_id',
        'appointment_id',
        'prescription',
        'file_name',
        'medical_leave',
        'deleted_at',
    ];

    public function getAppointmentFromReport()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }
}
