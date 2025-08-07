<?php

namespace App\Http\Controllers\Employee;

use App\Models\Clinic;

use App\Models\Company;
use App\Models\Appointment;
use App\Models\ScheduleDate;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use App\Models\CompanyClinic;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Dependent;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'company' => Company::find(Auth::user()->company_id),
            'appointments' => Appointment::where('user_id', Auth::user()->id)->get()
        ];

        return view('home', $data);
    }
    public function getClinicList()
    {
        $company = Company::find(Auth::user()->getCompanyFromUser->id);
        $data = [
            'clinics' => $company->getClinicsFromCompany()
                ->where('company_clinics.deleted_at', NULL)
                ->where('company_clinics.status', 'active')
                ->get()
        ];
        return view('employee.clinic-list', $data);
    }
    public function getBookAppointment($clinic)
    {
        $today = Carbon::now()->subDay();
        $clinicinfo = Clinic::where('slug', $clinic)->limit(1)->first();
        if ($clinicinfo) {
            $check = CompanyClinic::where('company_id', Auth::user()->company_id)->where('clinic_id', $clinicinfo->id)->count();
            if ($check >= 1) {
                $dates = DB::table('schedule_dates')
                    ->join('schedule_times', 'schedule_dates.id', '=', 'schedule_times.schedule_date_id')
                    ->where('schedule_dates.clinic_id', $clinicinfo->id)
                    ->where('schedule_dates.date', '>=', $today)
                    ->select('schedule_dates.*')
                    ->orderBy('schedule_dates.date', 'asc')
                    ->get();

                $dateIds = $dates->pluck('id')->toArray();

                $data = [
                    'clinic' => $clinicinfo,
                    'dates' => ScheduleDate::whereIn('id', $dateIds)->limit(7)->get(),
                    'dependents' => Dependent::where('status', 'active')->where('employee_id', auth()->user()->id)->get(),
                ];
                return view('employee.book-appointment', $data);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function postAppointment(Request $request, $clinic)
    {
        // dd($request->all());
        $clinicinfo = Clinic::where('slug', $clinic)->limit(1)->first();
        $timeslot = ScheduleTime::find($request->input('time'));

        if ($clinicinfo and $timeslot) {
            $check = CompanyClinic::where('company_id', Auth::user()->company_id)->where('clinic_id', $clinicinfo->id)->count();
            if ($check >= 1) {
                $appointment = new Appointment;
                $appointment->user_id = Auth()->user()->id;
                $appointment->clinic_id = $clinicinfo->id;
                $appointment->schedule_time_id = $request->input('time');
                $appointment->cause = $request->input('cause');
                //calculate claim amount
                if ($request->dependent == 0) {
                    $claim_amount = Auth()->user()->per_visit_claim;
                } else {
                    $depended = Dependent::where('status', 'active')->where('id', $request->dependent)->limit(1)->first();
                    $claim_amount = $depended->min_benefit;
                }

                if ($request->dependent == '0') {
                    $appointment->isself = 'Y';
                } else {
                    $appointment->isself = 'N';
                    $appointment->dependent_id = $request->dependent;
                }
                $appointment->claim_amount = $claim_amount;
                $appointment->save();
                return redirect()->back()->with('success', 'Appointment placed successfully. Wait for clinic approval.');
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function getAppointmented()
    {
        $data = [
            'appointments' => Appointment::where('user_id', Auth::user()->id)->get()
        ];
        return view('employee.appointmented-list', $data);
    }

    public function getViewAppointment($id)
    {
        $appointment = Appointment::where('id', $id)->where('user_id', Auth::user()->id)->limit(1)->first();
        if (is_null($appointment)) {
            return redirect()->back()->with('error', 'Appointment not available!');
        }

        $data = [
            'employee' => Auth::user(),
            'appointment' => $appointment,
        ];

        return view('employee.viewappointment', $data);
    }

    public function getDependent()
    {
        $data = [
            'dependents' => Dependent::where('status', 'active')->where("employee_id", auth()->user()->id)->get(),
        ];
        return view('employee.mydependent', $data);
    }

    public function changePasswordForm()
    {
        return view('employee.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }
}
