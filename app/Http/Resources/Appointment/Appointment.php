<?php

namespace App\Http\Resources\Appointment;

use Illuminate\Http\Request;
use App\Http\Resources\Appointment\Report as ReportResource;
use App\Http\Resources\Appointment\Account as AccountResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Appointment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->reschedule_time_id != null) {
            $appointment_date = $this->reScheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date;
            $appointment_time = $this->reScheduleTimeFromAppointment->time;
        } else {
            $appointment_date = $this->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date;
            $appointment_time = $this->scheduleTimeFromAppointment->time;
        }

        $prescription = $this->getPrescriptionReportFromAppointment;

        if ($prescription != null) {
            $medical_leave = $prescription->medical_leave != null ? $prescription->medical_leave : null;
        }

        return [
            'id' => $this->id,
            'appointment_date' => $appointment_date,
            'appointment_time' => $appointment_time,
            'status' => $this->status,
            'cause' => $this->cause,
            'payment_status' => $this->getPaymentFromAppointment != null ? 'complete' : 'incomplete',
            'total_amount' => $this->getPaymentFromAppointment != null ? $this->getPaymentFromAppointment->total_amount : null,
            'company_claim_amount' => $this->getPaymentFromAppointment != null ? $this->getPaymentFromAppointment->company_claim_amount : null,
            'paid_amount' => $this->getPaymentFromAppointment != null ? $this->getPaymentFromAppointment->paid_amount : null,
            'doctor' => $this->clinic_user_id != null ? $this->getClinicDoctorFromAppointment->name : " ",
            'clinic_id' => $this->clinic_id,
            'clinic_name' => $this->getClinicFromAppointment->name,
            'clinic_logo' => $this->getClinicFromAppointment->logo != null ? asset('site/uploads/clinic/' . $this->getClinicFromAppointment->logo) : null,
            'medical_leave' => $prescription != null ? $medical_leave : null,
            'created_at' => $this->created_at,
            'accounts' => AccountResource::collection($this->getAccountingFromAppointment),
            'reports' => ReportResource::collection($this->getReportFromAppointment),
        ];
    }
}
