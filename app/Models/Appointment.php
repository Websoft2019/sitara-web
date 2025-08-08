<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clinic_id',
        'clinic_user_id',
        'schedule_time_id',
        'reschedule_time_id',
        'cause',
        'status',
        'isself',
        'dependent_id',
        'deleted_at',
    ];

    public function getClinicFromAppointment()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function getEmployeeFromAppointment()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scheduleTimeFromAppointment()
    {
        return $this->belongsTo(ScheduleTime::class, 'schedule_time_id', 'id');
    }

    public function reScheduleTimeFromAppointment()
    {
        return $this->belongsTo(ScheduleTime::class, 'reschedule_time_id', 'id');
    }

    public function getClinicDoctorFromAppointment()
    {
        return $this->belongsTo(ClinicUser::class, 'clinic_user_id', 'id');
    }

    public function getReportFromAppointment()
    {
        return $this->hasMany(Report::class, 'appointment_id', 'id')
            ->orderByRaw("CASE WHEN report_name = 'prescription' THEN 0 ELSE 1 END, id ASC");
    }

    public function getPrescriptionReportFromAppointment()
    {
        return $this->hasOne(Report::class, 'appointment_id', 'id')->where('report_name', 'prescription')->where('deleted_at', null);
    }
    public function getOthersReportFromAppointment()
    {
        return $this->hasMany(Report::class, 'appointment_id', 'id')->where('report_name', '!=', 'prescription')->where('deleted_at', null);
    }

    public function getPaymentFromAppointment()
    {
        return $this->hasOne(Payment::class, 'appointment_id', 'id');
    }

    public function getAccountingFromAppointment()
    {
        return $this->hasMany(Account::class, 'appointment_id', 'id');
    }


        public function clinic()
    {
        return $this->belongsTo(\App\Models\Clinic::class);
    }
        
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 

        public function scheduleTime()
        {
            return $this->belongsTo(\App\Models\ScheduleTime::class);
        }

        public function rescheduleTime()
        {
            return $this->belongsTo(\App\Models\ScheduleTime::class, 'reschedule_time_id');
        }
}
