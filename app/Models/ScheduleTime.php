<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_date_id',
        'date',
        
        
    ];
    

    public function getScheduleDateFromScheduleTime()
    {
        return $this->belongsTo(ScheduleDate::class, 'schedule_date_id', 'id');
    }

    
    public function scheduleDate()
{
    return $this->belongsTo(\App\Models\ScheduleDate::class);
}
}
