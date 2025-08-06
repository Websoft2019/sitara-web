<?php

namespace App\Http\Resources\Schedule;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleTime extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $check1 = Appointment::where('reschedule_time_id', $this->id)->limit(1)->first();
        $check2 = Appointment::where('schedule_time_id', $this->id)->where('reschedule_time_id', null)->limit(1)->first();
        if (is_null($check1) && is_null($check2)) {
            $already_booked = false;
        } else {
            $already_booked = false;
        }
        return [
            'id' => $this->id,
            'time' => $this->time,
            'already_booked' => $already_booked
        ];
    }
}
