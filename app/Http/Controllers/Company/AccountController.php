<?php

namespace App\Http\Controllers\Company;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function getManageAccount(Request $request)
    {
        // return "Asdf";
        $companyId = Auth::user()->id;

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

        $users = User::distinct()
            ->join('companies', 'companies.id', '=', 'users.company_id')
            ->join('appointments', 'users.id', '=', 'appointments.user_id')
            ->join('clinics', 'appointments.clinic_id', '=', 'clinics.id')
            ->join('schedule_times', function ($join) {
                $join->on('appointments.schedule_time_id', '=', 'schedule_times.id')
                    ->orWhere('appointments.reschedule_time_id', '=', 'schedule_times.id');
            })
            ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
            ->where('companies.id', $companyId)
            ->where('appointments.status', 'completed')
            ->where(function ($query) use ($month, $year) {
                if ($month) {
                    $query->whereMonth('schedule_dates.date', $month)
                        ->whereYear('schedule_dates.date', $year);
                } else {
                    $query->whereMonth('schedule_dates.date', Carbon::now()->month)
                        ->whereYear('schedule_dates.date', Carbon::now()->year);
                }
            })
            ->select('users.*')
            ->get();

        $data = [
            'company' => Auth::user(),
            'users' => $users,
            'monthyear' => $sendmonthyear
        ];
        return view('company.account.manage', $data);
    }

    public function viewAppointmentDetails(Request $request, $employee_id)
    {
        $employee = User::where('employee_id', $employee_id)->where('company_id', Auth::user()->id)->limit(1)->first();
        if (is_null($employee)) {
            return redirect()->back()->with('error', 'Employee doesnot exists!');
        }

        $companyId = Auth::user()->id;

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
            'company' => Auth::user(),
            'employee' => $employee,
            'monthyear' => $sendmonthyear
        ];

        return view('company.account.detail', $data);
    }

    public function viewAppointmentAllDetails($employee_id, $id)
    {
        $employee = User::where('employee_id', $employee_id)->where('company_id', Auth::user()->id)->limit(1)->first();
        if (is_null($employee)) {
            return redirect()->back()->with('error', 'Employee doesnot exists!');
        }

        $appointment = Appointment::where('id', $id)->where('user_id', $employee->id)->limit(1)->first();
        if (is_null($appointment)) {
            return redirect()->back()->with('error', 'Appointment doesnot exists!');
        }

        $data = [
            'employee' => $employee,
            'appointment' => $appointment
        ];
        return view('company.account.alldetail', $data);
    }
}
