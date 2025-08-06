<?php

namespace App\Http\Resources\Schedule;

use Illuminate\Http\Request;
use App\Http\Resources\Schedule\ScheduleTime as ScheduleTimeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleDate extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'times' => ScheduleTimeResource::collection($this->getScheduleTimeFromScheduleDate)
        ];
    }
}
