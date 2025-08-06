<?php

namespace App\Http\Controllers\Clinic;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Report;
use App\Models\Account;
use App\Models\Company;
use App\Models\Payment;
use App\Models\ClinicUser;
use App\Models\Appointment;
use App\Models\Registrationrequest;
use Illuminate\Support\Str;
use App\Models\ScheduleDate;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Dependent;

class ClinicController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('clinic')->attempt($credentials, $request->remember)) {
            $user = ClinicUser::where('email', $request->email)->first();
            Auth::guard('clinic')->login($user);
            return redirect()->route('clinic.home');
        }
        return redirect()->route('clinic.login')->with('fail', 'Invalid Username and Password');
    }
    public function showLinkRequestForm()
    {
        return view('auth.clinic.passwords.email');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $email = $request->input('email');


        $check = ClinicUser::where('email', $email)->limit(1)->first();
        if ($check) {
            if ($check->status == 'active') {
                // save token
                $token = sha1(time() . '-clinic');
                ClinicUser::where('email', $email)->limit(1)->update(array('remember_token' => $token, 'email_verified_at' => Carbon::now()));
                // send email
                $maildata = [

                    'subject' => "Sitara Clinic Panel Password Reset Link :: Sitara",
                    'link' => "https://sitara.my/clinic/password/reset/" . $token,

                    'name' => $check->name,
                    'email' => $check->email,
                ];
                Mail::send('email.clinic.resetpassword', $maildata, function ($message) use ($maildata) {
                    $message->from('noreply.sitara@gmail.com', 'SITARA');
                    $message->sender($maildata['email'], $maildata['name']);
                    $message->to($maildata['email'], $maildata['name']);
                    $message->subject($maildata['subject']);
                    $message->priority(1);
                });
                return redirect()->back()->with('status', 'Password Reset Link has been send in your email');
            } else {
                return redirect()->back()->with('fail', 'Your account not active');
            }
        } else {
            return redirect()->back()->with('fail', 'We cant find a user with that email address.');
        }
    }
    public function showResetForm($token)
    {

        $check = ClinicUser::where('remember_token', $token)->limit(1)->first();

        if ($check) {
            $currenttime = Carbon::now();
            $sendtime = Carbon::parse($check->email_verified_at);
            $differenttime = $sendtime->diff($currenttime);
            if ($differenttime->h == 0) {
                $data = [
                    'token' => $token
                ];
                return view('auth.clinic.passwords.reset', $data);
            } else {
                return redirect()->route('clinic.password.request')->with('fail', 'Your password link has been expired');
            }
        } else {
            abort(404);
        }
    }
    public function reset(Request $request)
    {

        $this->validate($request, [
            'token' => 'required',
            'email' => 'email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);
        // dd('sdsdf');
        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('password');
        $en_password = Hash::make($password);
        $check = ClinicUser::where('email', $email)->where('remember_token', $token)->limit(1)->first();
        if ($check) {
            ClinicUser::where('email', $email)->where('remember_token', $token)->limit(1)->update(array('password' => $en_password, 'remember_token' => Null));
            return redirect()->route('clinic.login')->with('status', 'Your password reset successfully. Login with new password!');
        } else {
            abort(404);
        }
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('clinic.home');
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('clinic');
    }
    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function logout()
    {
        Auth::guard('clinic')->logout();
        return redirect()->route('clinic.login')->with('status', 'Logout Successfully!');
    }
    protected function loggedOut(Request $request)
    {
        return redirect()->route('clinic.login');
    }
    public function home()
    {
        $clinicId = Auth::user()->getClinicFromClinicUser->id;
        $todayAppointments = $appointments = Appointment::orderby('id', 'asc')
            ->join('schedule_times', function ($join) {
                $join->on('appointments.schedule_time_id', '=', 'schedule_times.id')
                    ->orWhere('appointments.reschedule_time_id', '=', 'schedule_times.id');
            })
            ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
            ->where('schedule_dates.clinic_id', $clinicId)
            ->where('schedule_dates.date', date('Y-m-d'))
            ->select('appointments.*')
            ->count();
        $todayServedAppointments = $appointments = Appointment::orderby('id', 'asc')
            ->join('schedule_times', function ($join) {
                $join->on('appointments.schedule_time_id', '=', 'schedule_times.id')
                    ->orWhere('appointments.reschedule_time_id', '=', 'schedule_times.id');
            })
            ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
            ->where('schedule_dates.clinic_id', $clinicId)
            ->where('schedule_dates.date', date('Y-m-d'))
            ->where('appointments.status', 'completed')
            ->select('appointments.*')
            ->count();
        $data = [
            'doctors' => ClinicUser::where('clinic_id', Auth()->user()->clinic_id)->where('status', 'active')->where('deleted_at', NULL)->where('role', 'doctor')->get(),
            'appointments' => Appointment::where('clinic_id', Auth()->user()->clinic_id)->where('clinic_user_id', NULL)->get(),
            'totalAppointments' => Appointment::where('clinic_id', Auth()->user()->clinic_id)->where('status', 'completed')->count(),
            'todayAppointments' => $todayAppointments,
            'todayServedAppointments' => $todayServedAppointments,
        ];
        return view('clinic.home', $data);
    }
    public function getAppointments(Request $request)
    {
        $clinicId = Auth::user()->getClinicFromClinicUser->id;

        if ($request->get('date')) {
            $appointments = Appointment::orderby('id', 'asc')
                ->join('schedule_times', function ($join) {
                    $join->on('appointments.schedule_time_id', '=', 'schedule_times.id')
                        ->orWhere('appointments.reschedule_time_id', '=', 'schedule_times.id');
                })
                ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
                ->where('schedule_dates.clinic_id', $clinicId)
                ->where('schedule_dates.date', $request->get('date'))
                ->select('appointments.*')
                ->get();

            $date = $request->get('date');
        } else {
            $appointments = Appointment::orderby('id', 'asc')
                ->join('schedule_times', function ($join) {
                    $join->on('appointments.schedule_time_id', '=', 'schedule_times.id')
                        ->orWhere('appointments.reschedule_time_id', '=', 'schedule_times.id');
                })
                ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
                ->where('schedule_dates.clinic_id', $clinicId)
                ->where('schedule_dates.date', date('Y-m-d'))
                ->select('appointments.*')
                ->get();
            $date = date('Y-m-d');
        }
        $data = [
            'doctors' => ClinicUser::where('clinic_id', Auth()->user()->clinic_id)->where('status', 'active')->where('deleted_at', NULL)->where('role', 'doctor')->get(),
            'appointments' => $appointments,
            'date' => $date

        ];

        // dd($data['appointments']);

        return view('clinic.appointment.manage', $data);
    }
    public function getManageCompany()
    {
        return view('clinic.company.manage');
    }
    public function getManageSchedule()
    {
        return view('clinic.schedule.manage');
    }
    public function getManageDoctors()
    {
        $data = [
            'doctors' => ClinicUser::where('clinic_id', Auth()->user()->clinic_id)->where('role', 'doctor')->where('deleted_at', null)->get()
        ];
        return view('clinic.doctor.manage', $data);
    }
    public function getDeleteClinicDoctor($id)
    {
        $doctor = ClinicUser::where('id', $id)->where('deleted_at', null)->where('role', 'doctor')->limit(1)->first();
        if (is_null($doctor)) {
            return redirect()->back()->with('error', 'Doctor doesnot exits');
        }

        $doctor->deleted_at = Carbon::now();
        $doctor->save();

        return redirect()->back()->with('success', 'Doctor removed successfully!');
    }
    public function postEditDoctor(Request $request, $id)
    {
        $doctor = ClinicUser::where('id', $id)->where('deleted_at', null)->where('role', 'doctor')->limit(1)->first();
        if (is_null($doctor)) {
            return redirect()->back()->with('error', 'Doctor doesnot exits');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clinic_users,email,' . $doctor->id,
            'status' => 'required|in:active,hidden',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);


        $image = $request->file('image');
        if ($image) {
            $getuniquename = sha1($image->getClientOriginalName() . time());
            $getextension = $image->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $image->move('site/uploads/clinic/user', $file_name);

            if ($doctor->image) {
                unlink('site/uploads/clinic/user/' . $doctor->image);
            }
        }

        $doctor->name = $request->input('name');
        $doctor->specialities = $request->input('specialities');
        $doctor->email = $request->input('email');
        $doctor->description = $request->input('description');
        if ($request->input('password')) {
            $doctor->password = Hash::make($request->input('password'));
        }
        if ($image) {
            $doctor->image = $file_name;
        }
        $doctor->role = 'doctor';
        $doctor->save();
        if ($request->input('password')) {
            $maildata = [
                'title' => "Your account as a doctor has been updated. You can now login to our website using the following credentials:",
                'subject' => "Your login Credentials",
                'link' => "sitara.my/clinic/login",
                'linktitle' => "Click here to Login",
                'name' => $doctor->name,
                'email' => $doctor->email,
                'password' => $request->input('password'),
            ];

            Mail::send('email.password.send', $maildata, function ($message) use ($maildata) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender('noreply.sitara@gmail.com', 'SITARA');
                $message->to($maildata['email'], $maildata['name']);
                $message->subject('Your login credentials');
                $message->priority(1);
            });
        }
        return redirect()->back()->with('success', 'Doctor login account created successfully.');
    }
    public function postAddDoctor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clinic_users,email',
            'status' => 'required|in:active,hidden',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
            'password' => 'required'
        ]);

        $image = $request->file('image');
        if ($image) {
            $getuniquename = sha1($image->getClientOriginalName() . time());
            $getextension = $image->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $image->move('site/uploads/clinic/user', $file_name);
        }

        $doctor = new ClinicUser;
        $doctor->clinic_id = Auth()->user()->clinic_id;
        $doctor->name = $request->input('name');
        $doctor->specialities = $request->input('specialities');
        $doctor->email = $request->input('email');
        $doctor->description = $request->input('description');
        $doctor->password = Hash::make($request->input('password'));
        if ($image) {
            $doctor->image = $file_name;
        }
        $doctor->role = 'doctor';
        $doctor->save();

        $maildata = [
            'title' => "Your account as a doctor has been created. You can now login to our website using the following credentials:",
            'subject' => "Your login Credentials",
            'link' => "sitara.my/clinic/login",
            'linktitle' => "Click here to Login",
            'name' => $doctor->name,
            'email' => $doctor->email,
            'password' => $request->input('password'),
        ];

        Mail::send('email.password.send', $maildata, function ($message) use ($maildata) {
            $message->from('noreply.sitara@gmail.com', 'SITARA');
            $message->sender('noreply.sitara@gmail.com', 'SITARA');
            $message->to($maildata['email'], $maildata['name']);
            $message->subject('Your login credentials');
            $message->priority(1);
        });
        return redirect()->back()->with('success', 'Doctor login account created successfully.');
    }
    public function postAssignDoctor(Request $request)
    {
        $appointmentid = $request->input('appointmentid');
        $doctorid = $request->input('doctor');

        $check1 = Appointment::where('id', $appointmentid)->where('clinic_id', Auth()->user()->clinic_id)->limit(1)->first();
        $check2 = ClinicUser::where('id', $doctorid)->where('clinic_id', Auth()->user()->clinic_id)->get();
        if ($check1 && $check2->count()) {
            $check1->clinic_user_id = $doctorid;
            $check1->save();

            $check1->status = "approved";
            $check1->save();

            $doctor = ClinicUser::where('id', $doctorid)->limit(1)->first();
            $appointment = Appointment::where('id', $appointmentid)->limit(1)->first();
            $clinic = $appointment->getClinicFromAppointment;

            $user = $appointment->getEmployeeFromAppointment;
            $maildata_for_employee = [
                'title' => "The appointment you have been requested have been successfully booked with the doctor <b>" . $doctor->name . ", " . $doctor->specialities . "</b> in <b>" . $clinic->name . "</b>. <br /> Hope, the scheduled time and date is suitable for your appointment.
                And you may have a great time and nice attitude as you may have expected.",
                'subject' => "Appointment",
                'link' => "sitara.my/home",
                'linktitle' => "Click here to View",
                'name' => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name,
                'email' => $user->email,
                'appointment_status' => $appointment->status,
                'clinic_name' => $clinic->name,
                'schedule_date' => $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y'),
                'schedule_time' => $appointment->scheduleTimeFromAppointment->time,
                'cause' => $appointment->cause,
            ];
            Mail::send('email.appointment.appointment', $maildata_for_employee, function ($message) use ($maildata_for_employee) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender('noreply.sitara@gmail.com', 'SITARA');
                $message->to($maildata_for_employee['email'], $maildata_for_employee['name']);
                $message->subject($maildata_for_employee['subject']);
                $message->priority(1);
            });

            $maildata_for_clinic = [
                'title' => "The booked appointment for <b>" . $user->getCompanyFromUser->name . "</b> by <b>" . $user->first_name . " " . $user->middle_name . " " . $user->last_name . "</b> has been scheduled with the doctor <b>" . $doctor->name . ", " . $doctor->specialities . " </b>.",
                'subject' => "Appointment Placed Done",
                'link' => "sitara.my/clinic/dashboard",
                'linktitle' => "Click here to View",
                'name' => $clinic->name,
                'email' => $clinic->email,
                'appointment_status' => $appointment->status,
                'company_name' => $user->getCompanyFromUser->name,
                'employee_name' => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name . ' (#' . $user->employee_id . ')',
                'schedule_date' => $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y'),
                'schedule_time' => $appointment->scheduleTimeFromAppointment->time,
                'cause' => $appointment->cause,
            ];

            Mail::send('email.appointment.clinic', $maildata_for_clinic, function ($message) use ($maildata_for_clinic) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender('noreply.sitara@gmail.com', 'SITARA');
                $message->to($maildata_for_clinic['email'], $maildata_for_clinic['name']);
                $message->subject($maildata_for_clinic['subject']);
                $message->priority(1);
            });

            $maildata_for_company = [
                'title' => "The booked appointment for <b>" . $user->first_name . " " . $user->middle_name . " " . $user->last_name . "(#" . $user->employee_id . ") </b> with <b>  " . $appointment->cause . "</b> has been scheduled with the doctor " . $doctor->name . ", " . $doctor->specialities . ". The appointment has been booked for <b>" . $clinic->name . "</b>. <br /> Please review the appointment and handle the employee with great gratitude.",
                'subject' => "Appointment Reqeust by Employee in Clinic has been Approved",
                'link' => "sitara.my/company/account/manage",
                'linktitle' => "Click here to View",
                'name' => $user->getCompanyFromUser->name,
                'email' => $user->getCompanyFromUser->email,
                'appointment_status' => $appointment->status,
                'clinic_name' => $clinic->name,
                'schedule_date' => $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y'),
                'schedule_time' => $appointment->scheduleTimeFromAppointment->time,
                'cause' => $appointment->cause,
            ];

            Mail::send('email.appointment.appointment', $maildata_for_company, function ($message) use ($maildata_for_company) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender('noreply.sitara@gmail.com', 'SITARA');
                $message->to($maildata_for_company['email'], $maildata_for_company['name']);
                $message->subject($maildata_for_company['subject']);
                $message->priority(1);
            });


            return redirect()->route('clinic.getPatients')->with('status', 'Doctor assign successfully');
        } else {
            abort(404);
        }
    }
    public function getPatients()
    {
        // return Dependent::where('isself', 'N')->where('dependent_id', 2)->first();
        $data = [
            'doctors' => ClinicUser::where('clinic_id', Auth()->user()->clinic_id)->where('status', 'active')->where('deleted_at', NULL)->where('role', 'doctor')->get(),
            'appointments' => Appointment::where('clinic_id', Auth()->user()->clinic_id)->where('clinic_user_id', '!=', null)->get()
        ];
        return view('clinic.patient.list', $data);
    }
    public function AjaxAppointmentDetail(Request $request)
    {
        $appointment = Appointment::find($request->get('appointmentid'));
        $patientinfo = User::find($appointment->user_id);
        $fullname = $patientinfo->first_name . ' ' . $patientinfo->middle_name . ' ' . $patientinfo->last_name;
        $companyinfo = Company::find($patientinfo->company_id);
        $latestcheckup = Appointment::where('user_id', $patientinfo->id)->where('clinic_user_id', '!=', NULL)->limit(1)->first();
        $appointmenttime = ScheduleTime::find($appointment->schedule_time_id);
        $appointmentdate = ScheduleDate::find($appointmenttime->schedule_date_id);
        $clinicinfo = Clinic::find($appointment->clinic_id);
        if ($patientinfo->image != Null) {
            $image = asset('site/uploads/company/employee/' . $patientinfo->image);
        } else {
            $image = asset('site/assets/img/nophoto.jpeg');
        }

        $dependentData = Dependent::find($appointment->dependent_id);

        $age = Carbon::parse($patientinfo->date_of_birth)->age;
        return response()->json(
            array(
                'cause11' => $appointment->cause,
                'patientName' => $fullname,
                'employeeID' => $patientinfo->employee_id,
                'ICNumber' => $patientinfo->ic_number,
                'patientAddress' => $patientinfo->address,
                'patientRace' => $patientinfo->race,
                'patientAge' => $patientinfo->gender,
                'patientEmail' => $patientinfo->email,
                'patientContact' => $patientinfo->phone_number,
                'companyName' => $companyinfo->name,
                'companyPost' => $patientinfo->post,
                'companyCoverage' => $patientinfo->per_visit_claim,
                'perviousCheckUpDate' => $latestcheckup->created_at->format('d M, Y'),
                'appointmentID' => $appointment->id,
                'appointmentTime' => ' | ' . $appointmenttime->time,
                'appointmentDate' => $appointmentdate->date->format('d M, Y') . ' ',
                'referClinicName' => $clinicinfo->name,
                'patientImage' => $image,
                'isself' => $appointment->isself == 'Y' ? 'Yes' : 'No',
                'dependentDataName' => $dependentData->name ?? 'NULL',
                'dependentDataRelation' => $dependentData->relation ?? 'NULL',
                'dependentDataDOB' => $dependentData->dob ?? 'NULL',
                'dependentDataICNumber' => $dependentData->icnumber ?? 'NULL',
                'dependentDataGender' => $dependentData->gender ?? 'NULL',

                200
            )
        );
    }
    public function getCheckUpPanel(Appointment $appointment)
    {
        if ($appointment->clinic_id != Auth::user()->getClinicFromClinicUser->id) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
        $appointmenttime = ScheduleTime::find($appointment->schedule_time_id);
        $appointmentdate = ScheduleDate::find($appointmenttime->schedule_date_id);
        $employeeinfo = User::find($appointment->user_id);
        $employeedependentinfo = \App\Models\Dependent::find($appointment->dependent_id);

        // if ($appointment->isself && $appointment->dependent_id) {
        //     $employeeinfo = \App\Models\Dependent::find($appointment->user_id);
        // } else {
        //     $employeeinfo = User::find($appointment->user_id);
        // }
        

        // this for either the payment is done or not
        $paymentStatus = Payment::where('appointment_id', $appointment->id)->limit(1)->first();

        $data = [
            'appointment' => $appointment,
            'employeeinfo' => $employeeinfo,
            'employeedependentinfo' => $employeedependentinfo,
            'appointtime' => $appointmenttime->time,
            'appointdate' => $appointmentdate->date,
            'clinicinfo' => Clinic::find($appointment->clinic_id),
            'companyinfo' => Company::find($employeeinfo->company_id),
            'paymentStatus' => $paymentStatus,
        ];
        return view('clinic.checkuppanel.index', $data);
    }

    public function getPaymentComplete(Appointment $appointment)
    {
        if ($appointment->clinic_id != Auth::user()->getClinicFromClinicUser->id) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        $total_amount = Account::where('appointment_id', $appointment->id)->sum('amount');
        $company_claim_amount = $appointment->getEmployeeFromAppointment->per_visit_claim;
        if ($total_amount < $company_claim_amount) {
            $company_claim_amount = $total_amount;
        }
        $paid_amount = ($total_amount - $company_claim_amount) > 0 ? ($total_amount - $company_claim_amount) : 0;
        $payment = Payment::where('appointment_id', $appointment->id)->limit(1)->first();
        if (is_null($payment)) {
            $payment = new Payment;
            $payment->appointment_id = $appointment->id;
            $payment->total_amount = $total_amount;
            $payment->company_claim_amount = $company_claim_amount;
            $payment->paid_amount = $paid_amount;

            $payment->save();

            $appointment->status = "completed";
            $appointment->save();

            $reports = Report::where('appointment_id', $appointment->id)->where('deleted_at', null)->get();

            $reportLinks = '';

            foreach ($reports as $report) {
                $fileLink = asset('site/uploads/reports/' . $report->file_name);
                $title = $report->report_name;

                // Concatenate the file link and title using a specific format
                $reportLinks .= "<a href='{$fileLink}'>{$title}</a><br>";
            }

            // $reportLinks now contains all the report file links with titles
            $medical_leave = Report::where('appointment_id', $appointment->id)->where('report_name', 'prescription')->limit(1)->first();
            if (is_null($medical_leave)) {
                $send_medical_leave = 0;
            } else {
                $send_medical_leave = $medical_leave->medical_leave != null ? $medical_leave->medical_leave : 0;
            }
            // You can use it as a string or within HTML tags
            $reportLinks = $reportLinks . ' <br /> Medical Leave: ' . $send_medical_leave;

            $doctor = ClinicUser::where('id', $appointment->clinic_user_id)->limit(1)->first();
            $clinic = $appointment->getClinicFromAppointment;

            $user = $appointment->getEmployeeFromAppointment;

            if ($appointment->isself == 'Y') {
                $titleForEmployee = "Your check-up has been completed successfully. The report of your check-up will be provided in the attachment below. <br />Hope, you will recover soon: <br />" . $reportLinks;
            } else {
                $getDependent = Dependent::findOrFail($appointment->dependent_id);
                $titleForEmployee =  $getDependent->name . "(" . $getDependent->relation . ") " . "check-up has been completed successfully. The report of your check-up will be provided in the attachment below. <br />Hope, you will recover soon: <br />" . $reportLinks;
            }

            $maildata_for_employee = [
                'title' => $titleForEmployee,
                'subject' => "Appointment Completed",
                'link' => "sitara.my/home",
                'linktitle' => "Click here to View",
                'name' => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name,
                'email' => $user->email,
                'appointment_status' => $appointment->status,
                'clinic_name' => $clinic->name,
                'schedule_date' => $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y'),
                'schedule_time' => $appointment->scheduleTimeFromAppointment->time,
                'cause' => $appointment->cause,
            ];
            Mail::send('email.appointment.appointment', $maildata_for_employee, function ($message) use ($maildata_for_employee) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender('noreply.sitara@gmail.com', 'SITARA');
                $message->to($maildata_for_employee['email'], $maildata_for_employee['name']);
                $message->subject($maildata_for_employee['subject']);
                $message->priority(1);
            });

            
            if ($appointment->isself == 'Y') {
                $titleForClinic = "The check-up and prescription process of <b>" . $user->getCompanyFromUser->name . "'s " . $user->first_name . " " . $user->middle_name . " " . $user->last_name . "</b> has been completed. <br /> Reports are below:<br />" . $reportLinks;
            } else {
                $getDependent = Dependent::findOrFail($appointment->dependent_id);
                $titleForClinic =  $getDependent->name . "(" . $getDependent->relation . ") " . "check-up has been completed successfully. The report of your check-up will be provided in the attachment below. <br />Hope, you will recover soon: <br />" . $reportLinks;
            }

            $maildata_for_clinic = [
                'title' => $titleForClinic,
                'subject' => "Appointment Completed of User",
                'link' => "sitara.my/clinic/dashboard",
                'linktitle' => "Click here to View",
                'name' => $clinic->name,
                'email' => $clinic->email,
                'appointment_status' => $appointment->status,
                'company_name' => $user->getCompanyFromUser->name,
                'employee_name' => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name . ' (#' . $user->employee_id . ')',
                'schedule_date' => $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y'),
                'schedule_time' => $appointment->scheduleTimeFromAppointment->time,
                'cause' => $appointment->cause,
            ];

            Mail::send('email.appointment.clinic', $maildata_for_clinic, function ($message) use ($maildata_for_clinic) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender('noreply.sitara@gmail.com', 'SITARA');
                $message->to($maildata_for_clinic['email'], $maildata_for_clinic['name']);
                $message->subject($maildata_for_clinic['subject']);
                $message->priority(1);
            });

            if ($appointment->isself == 'Y') {
                $titleForCompany = "The check-up of <b>" . $user->first_name . " " . $user->middle_name . " " . $user->last_name . "(#" . $user->employee_id . ") </b> has completed. The doctor has prescribed the medicine in the attachment below: <br /><b>  " . $reportLinks;
            } else {
                $getDependent = Dependent::findOrFail($appointment->dependent_id);
                $titleForCompany =  $getDependent->name . "(" . $getDependent->relation . ") " . "check-up has been completed successfully. The report of your check-up will be provided in the attachment below. <br />Hope, you will recover soon: <br />" . $reportLinks;
            }

            $maildata_for_company = [
                'title' => $titleForCompany,
                'subject' => "Appointment completed of employee",
                'link' => "sitara.my/company/account/manage",
                'linktitle' => "Click here to View",
                'name' => $user->getCompanyFromUser->name,
                'email' => $user->getCompanyFromUser->email,
                'appointment_status' => $appointment->status,
                'clinic_name' => $clinic->name,
                'schedule_date' => $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y'),
                'schedule_time' => $appointment->scheduleTimeFromAppointment->time,
                'cause' => $appointment->cause,
            ];

            Mail::send('email.appointment.appointment', $maildata_for_company, function ($message) use ($maildata_for_company) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender('noreply.sitara@gmail.com', 'SITARA');
                $message->to($maildata_for_company['email'], $maildata_for_company['name']);
                $message->subject($maildata_for_company['subject']);
                $message->priority(1);
            });

            return redirect()->back()->with('success', 'Payment Status Changed.');
        } else {
            return redirect()->back()->with('error', 'Payment Status already completed');
        }
    }

    public function postAddPrescriptionReport(Request $request, Appointment $appointment)
    {
        // this for either the payment is done or not
        $paymentStatus = Payment::where('appointment_id', $appointment->id)->limit(1)->first();
        if ($paymentStatus) {
            return redirect()->back()->with('error', 'Prescription report already uploaded/sent to the respective patient.');
        }

        if ($appointment->clinic_id != Auth::user()->getClinicFromClinicUser->id) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        $report = Report::where('appointment_id', $appointment->id)->where('report_name', 'prescription')->limit(1)->first();
        if (is_null($report)) {
            $report = new Report;
        }
        $prescription = $request->input('prescription');
        $medical_leave = $request->input('medical_leave');

        $pdf = new Dompdf();
        $pdf->loadHtml($prescription);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdfOutput = $pdf->output();
        $file_name = 'prescription' . time() . '.pdf';

        try {
            $path = public_path('site/uploads/reports/' . $file_name);
            file_put_contents($path, $pdfOutput);

            if ($report->file_name) {
                unlink('site/uploads/reports/' . $report->file_name);
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong.');
        }

        $report->report_name = "prescription";
        $report->appointment_id = $appointment->id;
        $report->prescription = $prescription;
        $report->medical_leave = $medical_leave;
        $report->file_name = $file_name;

        $report->save();

        $appointment->status = "completed";
        $appointment->save();

        return redirect()->back()->with('success', 'Prescription report uploaded successfully!');
    }

    public function postAddReports(Request $request, Appointment $appointment)
    {
        if ($appointment->clinic_id != Auth::user()->getClinicFromClinicUser->id) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        $request->validate([
            'report_name.*' => 'required',
            'file_name.*' => 'required|file',
        ]);


        $i = 0;
        foreach ($request->report_name as $item => $key) {
            $getDocumentname = $i . '' . md5(time());
            $i = $i + 1;
            $getPhotoExtension = $request->file_name[$item]->getClientOriginalExtension();
            $getrealDocumentname = Str::slug($request->report_name[$item]) . $getDocumentname . '.' . $getPhotoExtension;
            $request->file_name[$item]->move('site/uploads/reports/', $getrealDocumentname);
            $documents_data = array(
                'report_name' => $request->report_name[$item],
                'file_name' => $getrealDocumentname,
                'appointment_id' => $appointment->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );
            Report::insert($documents_data);
        }

        return redirect()->back()->with('success', 'Reports Added successfully!');
    }

    public function postUpdateReports(Request $request, Report $report)
    {
        if ($report->getAppointmentFromReport->clinic_id != Auth::user()->getClinicFromClinicUser->id) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        $request->validate([
            'report_name' => 'required',
            'file_name' => 'file',
        ]);

        $file_name = $request->file('file_name');
        if ($file_name) {
            $getDocumentname = md5(time());
            $getPhotoExtension = $file_name->getClientOriginalExtension();
            $getrealDocumentname = Str::slug($request->input('report_name')) . $getDocumentname . '.' . $getPhotoExtension;
            $file_name->move('site/uploads/reports/', $getrealDocumentname);

            if ($report->file_name) {
                unlink('site/uploads/reports/' . $report->file_name);
            }
        }

        $report->report_name = $request->input('report_name');
        if ($file_name) {
            $report->file_name = $getrealDocumentname;
        }
        $report->save();

        return redirect()->back()->with('success', 'Report updated successfully!');
    }

    public function postAddAccounting(Request $request, Appointment $appointment)
    {
        if ($appointment->clinic_id != Auth::user()->getClinicFromClinicUser->id) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
        $request->validate([
            'title.*' => 'required',
            'amount.*' => 'required|numeric',
        ]);
        foreach ($request->title as $item => $key) {
            $documents_data = array(
                'title' => $request->title[$item],
                'amount' => $request->amount[$item],
                'appointment_id' => $appointment->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            );
            Account::insert($documents_data);
        }
        return redirect()->back()->with('success', 'Accounting Added successfully!');
    }
    public function postUpdateAccounting(Request $request, Account $account)
    {
        if ($account->getAppointmentFromAccount->clinic_id != Auth::user()->getClinicFromClinicUser->id) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
        ]);

        $title = $request->input('title');
        $amount = $request->input('amount');

        $account->title = $title;
        $account->amount = $amount;
        $account->save();

        return redirect()->back()->with('success', 'Accounting updated successfully!');
    }

    public function getAjaxEmployeeDetail(Request $request)
    {
        $key = $request->get('search');

        // Search for the employee by employee_id, first_name, or ic_number
        $patient = User::where(function ($query) use ($key) {
            $query->where('employee_id', 'like', '%' . $key . '%')
                ->orWhere('first_name', 'like', '%' . $key . '%')
                ->orWhere('ic_number', 'like', '%' . $key . '%');
        })->first();

        if (!$patient) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        // Get active dependents for the employee
        $dependents = Dependent::where('employee_id', $patient->id)
                            ->where('status', 'active')
                            ->get();

        // Fetch company info
        $company = Company::find($patient->company_id);

        // Full name construction with fallbacks
        $fullname = trim("{$patient->first_name} {$patient->middle_name} {$patient->last_name}");

        // Image handling
        $imagePath = $patient->image 
            ? asset("site/uploads/company/employee/{$patient->image}")
            : asset('site/assets/img/nophoto.jpeg');

        // Build response data
        $response = [
            'patientName'      => $fullname,
            'employeeID'       => $patient->employee_id,
            'ICNumber'         => $patient->ic_number,
            'patientAddress'   => $patient->address,
            'patientRace'      => $patient->race,
            'patientAge'       => $patient->gender,
            'patientEmail'     => $patient->email,
            'patientContact'   => $patient->phone_number,
            'companyName'      => optional($company)->name,
            'companyPost'      => $patient->post,
            'companyCoverage'  => $patient->per_visit_claim,
            'patientImage'     => $imagePath,
            'listofdependants' => $dependents,
        ];

        return response()->json($response, 200);
    }


    public function postAddAppointmentByClinic(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'schedule_date' => 'required',
            'schedule_time' => 'required',
            'employee_id' => 'required|exists:users,employee_id',
            'clinic_user_id' => 'required|exists:clinic_users,id',
            'cause' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => $validator->errors()->first(),
            ];

            return response()->json($response, 200);
        }


        $schedule_date = $request->schedule_date;
        $schedule_time = $request->schedule_time;
        $clinic_user_id = $request->clinic_user_id;
        $cause = $request->cause;
        $employee_id = $request->employee_id;

        $user = User::where('employee_id', $employee_id)->where('status', 'active')->where('deleted_at', null)->limit(1)->first();

        if (is_null($user)) {
            $response = [
                'success' => false,
                'data' => "Employee with this employee ID not valid!",
            ];

            return response()->json($response, 200);
        }

        $current = Carbon::now()->subDay();
        if ($schedule_date < $current->toDateString()) {
            $response = [
                'success' => false,
                'data' => "Invalid Date",
            ];

            return response()->json($response, 200);
        }

        $date = ScheduleDate::where('date', $schedule_date)->where('clinic_id', Auth::user()->getClinicFromClinicUser->id)->limit(1)->first();

        if (is_null($date)) {
            $date = new ScheduleDate;
            $date->clinic_id = Auth::user()->getClinicFromClinicUser->id;
            $date->date = $schedule_date;
            $date->save();
        }

        $time = ScheduleTime::where('time', $schedule_time)->where('schedule_date_id', $date->id)->limit(1)->first();
        if (is_null($time)) {
            $time = new ScheduleTime;
            $time->schedule_date_id = $date->id;
            $time->time = $schedule_time;
            $time->save();
        }

        $appointment = new Appointment;
        $appointment->user_id = $user->id;
        $appointment->clinic_id = Auth::user()->getClinicFromClinicUser->id;
        $appointment->clinic_user_id = $clinic_user_id;
        $appointment->schedule_time_id = $time->id;
        $appointment->cause = $cause;
        $appointment->status = "approved";
        if($request->get('patient_id') !== 'employee'){
            $appointment->isself = 'N';
            $appointment->dependent_id = $request->get('patient_id');
            $depended = Dependent::where('status', 'active')->where('id', $request->get('patient_id'))->limit(1)->first();
            $appointment->claim_amount = $depended->min_benefit;
        }
        else{
            $appointment->claim_amount = $user->per_visit_claim;
        }

        $appointment->save();

        $response = [
            'success' => true,
            'data' => "Appointment placed successfully!",
        ];

        return response()->json($response, 200);
    }
    public function getClinicRegister()
    {
        return view('clinic.register');
    }
    public function postClinicRequestRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:clinics,name',
            'address' => 'required',
            'email' => 'required|email|unique:clinics,email',
            'bform' => 'required|mimes:jpeg,jpg,png,gif|max:2500'

        ]);
        $getPhotoExtension = $request->file('bform')->getClientOriginalExtension();
        $getrealDocumentname = md5(time()) . '.' . $getPhotoExtension;
        $request->file('bform')->move('site/uploads/bform/', $getrealDocumentname);
        $clinic = new Registrationrequest;
        $clinic->type = 'clinic';
        $clinic->name = $request->input('name');
        $clinic->registration_number = $request->input('mmcnumber');
        $clinic->contactperson = $request->input('contactperson');
        $clinic->contact_person_number = $request->input('contactnumber');
        $clinic->company_contact_number = $request->input('contactnumber');
        $clinic->address = $request->input('address');
        $clinic->city = $request->input('city');
        $clinic->state = $request->input('state');
        $clinic->postalcode = $request->input('postalcode');
        $clinic->openinghour = $request->input('openinghour');
        $clinic->email = $request->input('email');
        $clinic->bform = $getrealDocumentname;
        $clinic->save();
        return redirect()->back()->with('success', 'Clinic registration request send.');
    }
    public function postClinicRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:clinics,name',
            'address' => 'required',
            'email' => 'required|email|unique:clinics,email',

        ]);
        $clinic = new Clinic;
        $clinic->name = $request->input('name');
        $clinic->slug = Str::slug($request->input('name'));
        $clinic->registration_number = $request->input('mmcnumber');
        $clinic->contact_person = $request->input('contactperson');
        $clinic->contact_person_number = $request->input('contactnumber');
        $clinic->number = '123';
        $clinic->address = $request->input('address');
        $clinic->city = $request->input('city');
        $clinic->state = $request->input('state');
        $clinic->postalcode = $request->input('postalcode');
        $clinic->openinghour = $request->input('openinghour');
        $clinic->email = $request->input('email');
        $clinic->save();

        //username and password
        $random = Str::random(8);
        $password = Hash::make($random);
        $user = new ClinicUser;
        $user->clinic_id = $clinic->id;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $password;
        $user->email_verified_at = Carbon::now();
        $user->role = 'Admin';

        $user->save();

        $maildata = [
            'title' => "Your account has been created. You can now login to our website using the following credentials:",
            'subject' => "Your login Credentials",
            'link' => "sitara.my/clinic/login",
            'linktitle' => "Click here to Login",
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $random,
        ];

        Mail::send('email.password.send', $maildata, function ($message) use ($maildata) {
            $message->from('noreply.sitara@gmail.com', 'SITARA');
            $message->sender('noreply.sitara@gmail.com', 'SITARA');
            $message->to($maildata['email'], $maildata['name']);
            $message->subject('Your login credentials');
            $message->priority(1);
        });

        return redirect()->back()->with('success', 'Clinic user added successfully, Password was sent to users email.!');
    }
    public function getProfile()
    {
        $data = [
            'user' => ClinicUser::with('getClinicFromClinicUser')->find(Auth()->user()->id)
        ];
        return view('clinic.profile', $data);
    }
    public function postUpdateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'specialities' => 'required',


        ]);
        $image = $request->file('image');
        $user = ClinicUser::find(Auth()->user()->id);
        if ($request->input('password') != Null) {
            $request->validate([
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6',
            ]);
            $user->password = Hash::make($request->input('password'));
        }
        $user->name = $request->input('name');
        $user->specialities = $request->input('specialities');
        $user->description = $request->input('description');
        if ($request->file('image')) {
            if ($image != Null) {
                $getuniquename = sha1($image->getClientOriginalName() . time());
                $getextension = $image->getClientOriginalExtension();
                $file_name = $getuniquename . '.' . $getextension;
                $image->move('site/uploads/clinic/user/', $file_name);
                $user->image = $file_name;
            }
        }
        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function postUpdateClinicProfile(Request $request)
    {
        $clinic = Clinic::findOrFail(auth()->user()->clinic_id);

        // also change the name of clinicuser
        $clinicUser = ClinicUser::where("id", auth()->user()->id)->first();
        $clinicUser->name = $request->name;
        $clinicUser->update();

        $clinic->name = $request->name;
        $clinic->slug = Str::slug($request->name);

        // for logo
        if ($request->file('logo')) {
            $image = $request->file('logo');
            $getuniquename = sha1($image->getClientOriginalName() . time());
            $getextension = $image->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $image->move('site/uploads/clinic/', $file_name);
            $clinic->logo = $file_name;
        }

        $clinic->description = $request->description;
        $clinic->contact_person = $request->contactperson;
        $clinic->contact_person_number = $request->contactpersonnumber;
        $clinic->number = $request->contactno;
        $clinic->address = $request->address;
        $clinic->city = $request->city;
        $clinic->state = $request->state;
        $clinic->postalcode = $request->postalcode;
        $clinic->longitude = $request->longitude;
        $clinic->latitude = $request->latitude;
        $clinic->update();

        return redirect()->back()->with('success', 'Clinic profile updated successfully.');
    }

    public function getCancelPatientAppointment()
    {
        dd('sdfsdf');
    }
}
