<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'date'
    ];
    protected $casts = [
        'date' => 'date'
    ];

    public function getClinicFromScheduleDate()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function getScheduleTimeFromScheduleDate()
    {
        return $this->hasMany(ScheduleTime::class, 'schedule_date_id', 'id')->orderby('time', 'asc');
    }
}
