<?php

namespace App\Http\Controllers\Clinic;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\CompanyClinic;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mail;
use App\Models\Clinic;

class CompanyController extends Controller
{

    public function getManageCompany()
    {
        // get the companies id that are already connected with this clinic (auth)
        $companyIDsThatAreConnected = CompanyClinic::where('clinic_id', auth()->user()->getClinicFromClinicUser->id)
            ->where('company_id', '!=', NULL)
            ->pluck('company_id');

        $data = [
            'clinic' => Auth::user()->getClinicFromClinicUser,
            'companies' => Company::whereNotIn('id', $companyIDsThatAreConnected)->where('deleted_at', NULL)->get()
        ];
        return view('clinic.company.manage', $data);
    }
    
    public function getCompanyFromReferCode(Request $request)
    {
        $refer_code = $request->refer_code;
        $companyclinic = CompanyClinic::where('refer_code', $refer_code)->where('clinic_id', null)->limit(1)->first();
        if (is_null($companyclinic)) {
            $response = [
                'success' => false,
            ];
        } else {
            $response = [
                'success' => true,
                'name' => $companyclinic->getCompanyFromCompanyClinic->name,
                'logo' => $companyclinic->getCompanyFromCompanyClinic->logo,
                'address' => $companyclinic->getCompanyFromCompanyClinic->address,
                'number' => $companyclinic->getCompanyFromCompanyClinic->number,
                'contact_person' => $companyclinic->getCompanyFromCompanyClinic->contact_person,
                'contact_person_number' => $companyclinic->getCompanyFromCompanyClinic->contact_person_number,
                'email' => $companyclinic->getCompanyFromCompanyClinic->email,
                'employee_count' => $companyclinic->getCompanyFromCompanyClinic->getEmployeesFromCompany ? $companyclinic->getCompanyFromCompanyClinic->getEmployeesFromCompany->count() : 0,
            ];
        }

        return response()->json($response, 200);
    }

    public function addCompanyFromReferCode(Request $request)
    {
        $request->validate([
            'refer_code' => 'required|exists:company_clinics,refer_code'
        ]);

        $refer_code = $request->input('refer_code');
        $companyclinic = CompanyClinic::where('refer_code', $refer_code)->where('clinic_id', null)->limit(1)->first();
        if (is_null($companyclinic)) {
            return redirect()->back()->with('error', 'Compnay with this refer_code not available!');
        } else {
            $check = CompanyClinic::where('company_id', $companyclinic->company_id)->where('clinic_id', Auth::user()->getClinicFromClinicUser->id)->limit(1)->first();
            if (is_null($check)) {
                $companyclinic->clinic_id = Auth::user()->getClinicFromClinicUser->id;
                $companyclinic->status = 'active';
                $companyclinic->save();

                return redirect()->back()->with('success', 'Company added successfully!');
            } else {
                return redirect()->back()->with('error', 'Company already added!');
            }
        }
    }

    public function getRemoveCompany($id)
    {
        $linkinfo = CompanyClinic::find($id);
        //dd($linkinfo);

        //$company = Company::where('id', $id)->where('deleted_at', null)->limit(1)->first();

        if (is_null($linkinfo)) {
            return redirect()->back()->with('error', 'Company not found!');
        }

        $check = CompanyClinic::where('company_id', $linkinfo->company_id)->where('clinic_id', Auth::user()->getClinicFromClinicUser->id)->limit(1)->first();
        if (is_null($check)) {
            return redirect()->back()->with('error', 'Company is not connected.!');
        } else {
            $check->deleted_at = Carbon::now();
            $check->company_id = Null; // pahila yo theyana, error aaucha ki aaruma 
            $check->save();

            return redirect()->back()->with('success', 'Company removed successfully!');
        }
    }

    public function getManageAccounts(Request $request)
    {
        $clinicId = Auth::user()->getClinicFromClinicUser->id;
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

        $companies = Company::distinct()
            ->join('users', 'companies.id', '=', 'users.company_id')
            ->join('appointments', 'users.id', '=', 'appointments.user_id')
            ->join('clinics', 'appointments.clinic_id', '=', 'clinics.id')
            ->join('schedule_times', function ($join) {
                $join->on('appointments.schedule_time_id', '=', 'schedule_times.id')
                    ->orWhere('appointments.reschedule_time_id', '=', 'schedule_times.id');
            })
            ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
            ->where('clinics.id', $clinicId)
            ->where('appointments.status', 'completed')
            ->where(function ($query) use ($month, $year) {
                if ($month) {
                    $query->whereMonth('schedule_dates.date', $month)
                        ->whereYear('schedule_dates.date', $year);
                }
            })
            ->select('companies.*')
            ->get();
        $data = [
            'clinic' => Auth::user()->getClinicFromClinicUser,
            'companies' => $companies,
            'monthyear' => $sendmonthyear
        ];
        return view('clinic.account.manage', $data);
    }
    public function getClinicSendInvokeCodeToCompany(Company $company)
    {
        // dd($company);
        $refer_code = Str::random(10);
        $check = CompanyClinic::where('clinic_id', Auth::user()->clinic_id)->where('request_company_id', $company->id)->orWhere('refer_code', $refer_code)->limit(1)->first();
        $clinicinfo = Clinic::find(Auth::user()->clinic_id);
        // return $check;
        if (is_null($check)) {
            $code = new CompanyClinic;
            $code->clinic_id = Auth::user()->clinic_id;
            $code->request_company_id = $company->id;
            $code->request_clinic_id = Auth::user()->clinic_id;
            // $code->company_id = $company->id;
            $code->refer_code = $refer_code;
            $code->save();
            // send email

            $maildata = [
                'title' => $clinicinfo->name . " wants to connect with you use the following refer code to connect:",
                'subject' => "Client Partnership Request",
                'link' => "sitara.my/clinic/login",
                'linktitle' => "Click here to go that link",
                'name' => $company->name,
                'email' => $company->email,
                'company_email' => Auth::user()->email,
                'company_name' => Auth::user()->name,
                'refer_code' => $refer_code,
            ];
            Mail::send('email.company.refercode', $maildata, function ($message) use ($maildata) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender($maildata['company_email'], $maildata['company_name']);
                $message->to($maildata['email'], $maildata['name']);
                $message->subject('Client Partnership Request');
                $message->priority(1);
            });

            return redirect()->back()->with('success', 'Partnership request send successfully.!');
        } else {
            return redirect()->back()->with('error', 'Partnership request already send.!');
        }
    }
}
