<?php

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

function getAppointmentofSelectedMonth($clinic_id, $company_id, $monthyear)
{
    if ($monthyear) {
        $explode = explode('-', $monthyear);
        $month = $explode[1];
        $year = $explode[0];
    } else {
        $month = date('m');
        $year = date('Y');
    }

    $apps = DB::table('appointments as appointment')
        ->join('users as user', 'appointment.user_id', '=', 'user.id')
        ->join('companies as company', 'company.id', '=', 'user.company_id')
        ->join('schedule_times', function ($join) {
            $join->on('appointment.schedule_time_id', '=', 'schedule_times.id')
                ->orWhere('appointment.reschedule_time_id', '=', 'schedule_times.id');
        })
        ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
        ->where(function ($query) use ($month, $year) {
            $query->whereMonth('schedule_dates.date', $month)
                ->whereYear('schedule_dates.date', $year);
        })
        ->where('appointment.status', 'completed')
        ->where('appointment.clinic_id', $clinic_id)
        ->where('company.id', $company_id)
        ->select('appointment.*')
        ->get();

    $appId = $apps->pluck('id')->toArray();

    $appointments = Appointment::whereIn('id', $appId)->get();

    return $appointments;
}

function getAppointmentofSelectedMonthofClinic($user_id, $company_id, $monthyear)
{
    if ($monthyear) {
        $explode = explode('-', $monthyear);
        $month = $explode[1];
        $year = $explode[0];
    } else {
        $month = date('m');
        $year = date('Y');
    }
    $apps = DB::table('appointments as appointment')
        ->join('users as user', 'appointment.user_id', '=', 'user.id')
        ->join('companies as company', 'company.id', '=', 'user.company_id')
        ->join('schedule_times', function ($join) {
            $join->on('appointment.schedule_time_id', '=', 'schedule_times.id')
                ->orWhere('appointment.reschedule_time_id', '=', 'schedule_times.id');
        })
        ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
        ->where(function ($query) use ($month, $year) {
            $query->whereMonth('schedule_dates.date', $month)
                ->whereYear('schedule_dates.date', $year);
        })
        ->where('appointment.status', 'completed')
        ->where('appointment.user_id', $user_id)
        ->where('company.id', $company_id)
        ->select('appointment.*')
        ->get();

    $appId = $apps->pluck('id')->toArray();

    $appointments = Appointment::whereIn('id', $appId)->get();

    $totalamount = Payment::whereIn('appointment_id', $appId)->sum('total_amount');

    return $appointments;
}

function getAppointmentForAdminOfCompany($company_id, $monthyear)
{
    if ($monthyear) {
        $explode = explode('-', $monthyear);
        $month = $explode[1];
        $year = $explode[0];
    } else {
        $month = date('m');
        $year = date('Y');
    }
    $apps = DB::table('appointments as appointment')
        ->join('users as user', 'appointment.user_id', '=', 'user.id')
        ->join('companies as company', 'company.id', '=', 'user.company_id')
        ->join('schedule_times', function ($join) {
            $join->on('appointment.schedule_time_id', '=', 'schedule_times.id')
                ->orWhere('appointment.reschedule_time_id', '=', 'schedule_times.id');
        })
        ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
        ->where(function ($query) use ($month, $year) {
            $query->whereMonth('schedule_dates.date', $month)
                ->whereYear('schedule_dates.date', $year);
        })
        ->where('appointment.status', 'completed')
        ->where('company.id', $company_id)
        ->select('appointment.*')
        ->get();

    $appId = $apps->pluck('id')->toArray();

    $appointments = Appointment::whereIn('id', $appId)->get();

    $totalamount = Payment::whereIn('appointment_id', $appId)->sum('total_amount');

    return $appointments;
}

function getAppointmentForAdminOfClinic($clinic_id, $monthyear)
{
    if ($monthyear) {
        $explode = explode('-', $monthyear);
        $month = $explode[1];
        $year = $explode[0];
    } else {
        $month = date('m');
        $year = date('Y');
    }
    $apps = DB::table('appointments as appointment')
        ->join('clinics as clinic', 'clinic.id', '=', 'appointment.clinic_id')
        ->join('schedule_times', function ($join) {
            $join->on('appointment.schedule_time_id', '=', 'schedule_times.id')
                ->orWhere('appointment.reschedule_time_id', '=', 'schedule_times.id');
        })
        ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
        ->where(function ($query) use ($month, $year) {
            $query->whereMonth('schedule_dates.date', $month)
                ->whereYear('schedule_dates.date', $year);
        })
        ->where('appointment.status', 'completed')
        ->where('clinic.id', $clinic_id)
        ->select('appointment.*')
        ->get();

    $appId = $apps->pluck('id')->toArray();

    $appointments = Appointment::whereIn('id', $appId)->get();

    $totalamount = Payment::whereIn('appointment_id', $appId)->sum('total_amount');

    return $appointments;
}

function clinicAvailableToday($clinic_id)
{
    $check = DB::table('clinics')
        ->join('schedule_dates', 'schedule_dates.clinic_id', '=', 'clinics.id')
        ->join('schedule_times', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
        ->where('schedule_dates.date', date('Y-m-d'))
        ->where('clinics.id', $clinic_id)
        ->count();

    if ($check == 0) {
        return false;
    } else {
        return true;
    }
}
