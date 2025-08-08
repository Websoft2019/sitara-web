<?php

namespace App\Http\Controllers\Clinic;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\ScheduleDate;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function getManageSchedule(Request $request)
    {
        if ($request->get('month')) {
            $monthyear = $request->input('month');
            $explode = explode('-', $monthyear);
            $month = $explode[1];
            $year = $explode[0];
        } else {
            $month = date('m');
            $year = date('Y');
        }

        $now = Carbon::now()->toDateString();
        $explodenow = explode('-', $now);
        $day = $explodenow[2];

        $sendmonthyear = Carbon::createFromDate($year, $month, $day);
        $data = [
            'dates' => ScheduleDate::orderby('date', 'asc')
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->where('clinic_id', Auth::user()->getClinicFromClinicUser->id)
                ->get(),

            'request' => $request,
            'monthyear' => $sendmonthyear
        ];
        // dd($request->month, $data['monthyear']);
        return view('clinic.schedule.manage', $data);
    }

    public function postAddScheduleDate(Request $request)
    {
        $request->validate([
            'date' => 'required',
        ]);

        $date = $request->input('date');
        $current = Carbon::now()->subDay();
        if ($date > $current->toDateString()) {
            $schedule_date = ScheduleDate::where('clinic_id', Auth::user()->getClinicFromClinicUser->id)->where('date', $date)->limit(1)->first();
            if (is_null($schedule_date)) {
                for ($i = 0; $i < 7; $i++) {
                    $schedule_date = new ScheduleDate;
                    $schedule_date->clinic_id = Auth::user()->getClinicFromClinicUser->id;
                    $schedule_date->date = Carbon::parse($date)->addDays($i)->toDateString();
                    $schedule_date->save();
                }
                return redirect()->back()->with('success', 'Schedule date added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Date already exists!');
            }
        } else {
            return redirect()->back()->with('error', 'Date already gone!');
        }
    }

    public function postSetTimeForWeekend(Request $request)
    {
        // return $request;
        // $request->validate([
        //     'timeOpen' => 'required',
        //     'timeClose' => 'required',
        // ]);

        $openingTime = Carbon::parse($request->input('openTime'));
        $closingTime = Carbon::parse($request->input('closeTime'));
        $totalNumberOfHours = $closingTime->diffInHours($openingTime);

        $current = Carbon::now()->subDay();
        $clinic_id = Auth::user()->getClinicFromClinicUser->id;
        $dates = ScheduleDate::where('clinic_id', $clinic_id)->where('date', '>', $current->toDateString())->get();

        foreach ($dates as $date) {
            $schedule_time = ScheduleTime::where('schedule_date_id', $date->id)->where('time', $request->input('openTime'))->first();
            if (is_null($schedule_time)) {
                for ($i = 0; $i < $totalNumberOfHours; $i++) {
                    $schedule_time = new ScheduleTime;
                    $schedule_time->schedule_date_id = $date->id;
                    $schedule_time->time = $openingTime->copy()->addHours($i)->toTimeString();
                    $schedule_time->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Schedule time added Successfully!');
    }

    public function postAddTime(Request $request, ScheduleDate $date)
    {
        $request->validate([
            'time' => 'required',
        ]);

        $time = $request->input('time');
        $current = Carbon::now()->subDay();
        if ($date->date > $current->toDateString()) {
            $schedule_time = ScheduleTime::where('schedule_date_id', $date->id)->where('time', $time)->limit(1)->first();
            if (is_null($schedule_time)) {
                $schedule_time = new ScheduleTime;
                $schedule_time->schedule_date_id = $date->id;
                $schedule_time->time = $time;
                $schedule_time->save();
                return redirect()->back()->with('success', 'Schedule time added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Time already exists!');
            }
        } else {
            return redirect()->back()->with('error', 'Date already gone!');
        }
    }

    public function getDeleteScheduleTime(ScheduleTime $time)
    {
        $check = Appointment::where('schedule_time_id', $time->id)->orWhere('reschedule_time_id', $time->id)->limit(1)->first();

        if (is_null($check)) {
            $time->delete();
            return redirect()->back()->with('success', 'Time Deleted Successfully!');
        } else {
            return redirect()->back()->with('error', 'Cant able to delete, Time alredy in appointment list!');
        }
    }
}
