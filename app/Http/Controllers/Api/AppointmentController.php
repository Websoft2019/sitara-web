<?php

namespace App\Http\Controllers\Api;

use App\Models\Clinic;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Dependent;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\Appointment\Appointment as ResourcesAppointment;

class AppointmentController extends BaseController
{
    public function postAppointment(Request $request)
    {
        // return "hello";
        $validator = Validator::make($request->all(), [
            'clinic_id' => 'required|integer|exists:clinics,id',
            'schedule_time_id' => 'required|exists:schedule_times,id',
            'cause' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors(), 400);
        }

        $clinic_id = $request->input('clinic_id');
        $clinic = Clinic::where('id', $clinic_id)->where('status', 'active')->where('deleted_at', null)->limit(1)->first();
        if (is_null($clinic)) {
            return $this->sendError('Clinic not found!', 'Clinic with this id is not available', 404);
        }

        $schedule_time_id = $request->input('schedule_time_id');
        $schedule_time = ScheduleTime::where('id', $schedule_time_id)->limit(1)->first();
        if (is_null($schedule_time)) {
            return $this->sendError('Time not found!', 'Time with this id is not available', 404);
        }

        if ($schedule_time->getScheduleDateFromScheduleTime->clinic_id != $clinic->id) {
            return $this->sendError('Time not found!', 'Time with this id is not available', 404);
        }

        $check1 = Appointment::where('reschedule_time_id', $schedule_time_id)->where('status', '!=', 'cancelled')->limit(1)->first();
        $check2 = Appointment::where('schedule_time_id', $schedule_time_id)->where('reschedule_time_id', null)->where('status', '!=', 'cancelled')->limit(1)->first();
        if (is_null($check1) && is_null($check2)) {
            $already_booked = false;
        } else {
            $already_booked = false;
        }

        if ($already_booked == true) {
            return $this->sendError('Unable to Book!', 'This time is already booked by someone!', 405);
        }

        $appointment = new Appointment;
        $appointment->user_id = Auth::user()->id;
        $appointment->clinic_id = $clinic->id;
        $appointment->schedule_time_id = $schedule_time->id;
        $appointment->cause = $request->input('cause');
        $appointment->status = "pending";

        if ($request->dependent == '0') {
            $appointment->isself = 'Y';
            $appointment->claim_amount = Auth::user()->per_visit_claim;
            
        } else {
            $appointment->isself = 'N';
            $appointment->dependent_id = $request->dependent;
            $depended = Dependent::where('status', 'active')->where('id', $request->dependent)->limit(1)->first();
            $appointment->claim_amount = $depended->min_benefit;
            
        }

        $appointment->save();

        // $maildata_for_employee = [
        //     'title' => "You have requested for an appointment due to <b>" . $appointment->cause . "</b> in <b>" . $clinic->name . "</b>. <br /> Please, wait for the reply from the clinic for further processing.",
        //     'subject' => "Appointment booked successfully! wait until clinic response.",
        //     'link' => "sitara.my/home",
        //     'linktitle' => "Click here to View",
        //     'name' => Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name,
        //     'email' => Auth::user()->email,
        //     'appointment_status' => $appointment->status,
        //     'clinic_name' => $clinic->name,
        //     'schedule_date' => $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y'),
        //     'schedule_time' => $appointment->scheduleTimeFromAppointment->time,
        //     'cause' => $appointment->cause,
        // ];
        // Mail::send('email.appointment.appointment', $maildata_for_employee, function ($message) use ($maildata_for_employee) {
        //     $message->from('noreply.sitara@gmail.com', 'SITARA');
        //     $message->sender('noreply.sitara@gmail.com', 'SITARA');
        //     $message->to($maildata_for_employee['email'], $maildata_for_employee['name']);
        //     $message->subject($maildata_for_employee['subject']);
        //     $message->priority(1);
        // });

        // $maildata_for_clinic = [
        //     'title' => "There is an appointment from <b>" . Auth::user()->getCompanyFromUser->name . "</b> by <b>" . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->last_name . "</b> in your clinic for <b>" . $appointment->cause . " </b>. <br />
        //     Hope, the employee is suitable with the scheduled date and time. <br />
        //     And the employee is happy with the gratitude toward the treatment.",
        //     'subject' => "Appointment Request",
        //     'link' => "sitara.my/clinic/dashboard",
        //     'linktitle' => "Click here to View",
        //     'name' => $clinic->name,
        //     'email' => $clinic->email,
        //     'appointment_status' => $appointment->status,
        //     'company_name' => Auth::user()->getCompanyFromUser->name,
        //     'employee_name' => Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name . ' (#' . Auth::user()->employee_id . ')',
        //     'schedule_date' => $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y'),
        //     'schedule_time' => $appointment->scheduleTimeFromAppointment->time,
        //     'cause' => $appointment->cause,
        // ];

        // Mail::send('email.appointment.clinic', $maildata_for_clinic, function ($message) use ($maildata_for_clinic) {
        //     $message->from('noreply.sitara@gmail.com', 'SITARA');
        //     $message->sender('noreply.sitara@gmail.com', 'SITARA');
        //     $message->to($maildata_for_clinic['email'], $maildata_for_clinic['name']);
        //     $message->subject($maildata_for_clinic['subject']);
        //     $message->priority(1);
        // });

        // $maildata_for_company = [
        //     'title' => "There is an appointment of <b>" . Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->last_name . "(#" . Auth::user()->employee_id . ") </b> with <b>  " . $appointment->cause . "</b>. The appointment has been booked for <b>" . $clinic->name . "</b>. <br /> Please review the appointment and handle the employee with great gratitude.",
        //     'subject' => "Appointment Reqeust by Employee in Clinic",
        //     'link' => "sitara.my/company/account/manage",
        //     'linktitle' => "Click here to View",
        //     'name' => Auth::user()->getCompanyFromUser->name,
        //     'email' => Auth::user()->getCompanyFromUser->email,
        //     'appointment_status' => $appointment->status,
        //     'clinic_name' => $clinic->name,
        //     'schedule_date' => $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y'),
        //     'schedule_time' => $appointment->scheduleTimeFromAppointment->time,
        //     'cause' => $appointment->cause,
        // ];

        // Mail::send('email.appointment.appointment', $maildata_for_company, function ($message) use ($maildata_for_company) {
        //     $message->from('noreply.sitara@gmail.com', 'SITARA');
        //     $message->sender('noreply.sitara@gmail.com', 'SITARA');
        //     $message->to($maildata_for_company['email'], $maildata_for_company['name']);
        //     $message->subject($maildata_for_company['subject']);
        //     $message->priority(1);
        // });


        return $this->sendResponse(null, "Appointment placed succesfully, Wait until Clinic response.");
    }

    public function getAppointmentCancel($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->where('status', '!=', 'cancelled')
            ->where('deleted_at', null)
            ->where('clinic_user_id', null)
            ->limit(1)
            ->first();

        if (is_null($appointment)) {
            return $this->sendError('Appointment not found!', 'Appointment with this id is not available', 404);
        }

        $appointment->status = "cancelled";
        $appointment->save();
        return $this->sendResponse(null, 'Appointments cancelled successfully!');
    }

    public function getAllUpcomingAppointments(Request $request)
    {
        $size = $request->size ?? 10;
        $appointments = Appointment::where('user_id', Auth::user()->id)->whereIn('status', ['pending', 'approved', 'rescheduled'])->latest()->paginate($size);

        return $this->sendResponse(ResourcesAppointment::collection($appointments)->response()->getData(true), 'Appointments fetched successfully!');
    }
    public function getAllCompletedAppointments(Request $request)
    {
        $size = $request->size ?? 10;
        $appointments = Appointment::where('user_id', Auth::user()->id)->where('status', 'completed')->latest()->paginate($size);

        return $this->sendResponse(ResourcesAppointment::collection($appointments)->response()->getData(true), 'Appointments fetched successfully!');
    }
    public function getAllCancelledAppointments(Request $request)
    {
        $size = $request->size ?? 10;
        $appointments = Appointment::where('user_id', Auth::user()->id)->where('status', 'cancelled')->latest()->paginate($size);

        return $this->sendResponse(ResourcesAppointment::collection($appointments)->response()->getData(true), 'Appointments fetched successfully!');
    }

    public function getAllDataFromAppointment()
    {
        $appointment = Appointment::orderby('id', 'desc')->limit(1)->first();
        // dd($appointment);

        $clinic = $appointment->getClinicFromAppointment;
        // dd($clinic);

        // yedi kunai doctor lai assign gareko xa vaney yaniki clinic_user_id ma data xa vaney
        $doctor = $appointment->getClinicDoctorFromAppointment();
        // dd($doctor);

        //employee vaneko user table ma vayeko
        $employee = $appointment->getEmployeeFromAppointment;
        // dd($employee);

        $schedule_time = $appointment->scheduleTimeFromAppointment;
        // dd($schedule_time);

        // yedi reschedule gareko xa vaney tw reschedule time ma ni id hunxa testo bela check garera reschedule time patta launa
        $rescheduce_time = $appointment->reScheduleTimeFromAppointment();
        // dd($rescheduce_time);

        // aba schedule time aayo tyo time ko date patta launa
        $schedule_date = $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime;
        // or
        $schedule_date = $schedule_time->getScheduleDateFromScheduleTime;
        // dd($schedule_date);

        // date bata tyo din ka time patta launa, yo chai aarray ma aaucha foreach launa paryo
        $schedule_times = $schedule_date->getScheduleTimeFromScheduleDate;
        // dd($schedule_times);

        // appointment ka report fetch garna savvai
        $reports = $appointment->getReportFromAppointment;
        dd($reports);
    }
}
