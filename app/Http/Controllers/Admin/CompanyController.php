<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\CompanyClinic;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Dependent;
use App\Models\Appointment;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class CompanyController extends Controller
{
    public function getManageCompany()
    {
        $data = [
            'companies' => Company::where('deleted_at', null)->get()
        ];
        return view('admin.company.manage', $data);
    }

    public function getDeleteCompany($slug)
    {
        $company = Company::where('slug', $slug)->where('deleted_at', null)->limit(1)->first();

        if (is_null($company)) {
            return redirect()->back()->with('error', 'Company doesnot exists!');
        }

        // deleting if the company already connected with other clinic
        $clinics = CompanyClinic::where('company_id', $company->id)->get();
        foreach ($clinics as $clinic) {
            $clinic->deleted_at = Carbon::now();
            $clinic->save();
        }

        $company->deleted_at = Carbon::now();
        $company->save();

        return redirect()->back()->with('sucess', 'Company deleted successfully!');
    }

    public function getEditCompany($slug)
    {
        $company = Company::where('slug', $slug)->where('deleted_at', null)->limit(1)->first();

        if (is_null($company)) {
            return redirect()->back()->with('error', 'Company doesnot exists!');
        }

        $data = [
            'company' => $company
        ];

        return view('admin.company.edit', $data);
    }

    public function postEditCompany(Request $request, $slug)
    {
        $company = Company::where('slug', $slug)->where('deleted_at', null)->limit(1)->first();

        if (is_null($company)) {
            return redirect()->route('admin.getManageCompany')->with('error', 'Company doesnot exists!');
        }

        $request->validate([
            'name' => 'required|unique:companies,name,' . $company->id,
            'address' => 'required',
            'registration_number' => 'required|unique:companies,registration_number,' . $company->id,
            'commission' => 'required|numeric',
            'email' => 'required|email|unique:companies,email,' . $company->id,
            'status' => 'required|in:active,hidden',
            'number' => 'required|unique:companies,number,' . $company->id,
            'contact_person' => 'required',
            'contact_person_number' => 'required|unique:companies,contact_person_number,' . $company->id,
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $name = $request->input('name');
        $slug = Str::slug($name);
        $address = $request->input('address');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $registration_number = $request->input('registration_number');
        $email = $request->input('email');
        $commission = $request->input('commission');
        $status = $request->input('status');
        $number = $request->input('number');
        $contact_person = $request->input('contact_person');
        $contact_person_number = $request->input('contact_person_number');
        $description = $request->input('description');

        $logo = $request->file('logo');
        if ($logo) {
            $getuniquename = sha1($logo->getClientOriginalName() . time());
            $getextension = $logo->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $logo->move('site/uploads/company/', $file_name);

            if ($company->logo) {
                unlink('site/uploads/company/' . $company->logo);
            }
        }

        $company->name = $name;
        $company->slug = $slug;
        $company->address = $address;
        $company->longitude = $longitude;
        $company->latitude = $latitude;
        $company->registration_number = $registration_number;
        $company->email = $email;
        $company->commission = $commission;
        $company->status = $status;
        $company->number = $number;
        $company->contact_person = $contact_person;
        $company->contact_person_number = $contact_person_number;
        $company->description = $description;
        if ($logo) {
            $company->logo = $file_name;
        }

        $company->save();
        return redirect()->route('admin.getManageCompany')->with('success', 'Company details updated successfully!.');
    }

    public function getSendPasswordForCompany($slug)
    {
        $company = Company::where('slug', $slug)->where('deleted_at', null)->limit(1)->first();

        if (is_null($company)) {
            return redirect()->back()->with('error', 'Company doesnot exists!');
        }

        $random = Str::random(8);
        $password = Hash::make($random);

        $company->password = $password;
        $company->is_first_login = "yes";
        $company->save();

        $maildata = [
            'title' => "Your account password has been updated. You can now login to our website using the following credentials:",
            'subject' => "Your login Credentials",
            'link' => "sitara.my/company/login",
            'linktitle' => "Click here to Login",
            'name' => $company->name,
            'email' => $company->email,
            'password' => $random,
        ];

        // Mail::to($company->email)->send(new SendPasswordMail($maildata));

        Mail::send('email.password.send', $maildata, function ($message) use ($maildata) {
            $message->from('noreply.sitara@gmail.com', 'SITARA');
            $message->sender('noreply.sitara@gmail.com', 'SITARA');
            $message->to($maildata['email'], $maildata['name']);
            $message->subject('Your login credentials');
            $message->priority(1);
        });


        return redirect()->back()->with('success', 'Password was sent to users email.!');
    }

    public function postAddCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:companies,name',
            'address' => 'required',
            'registration_number' => 'required|unique:companies,registration_number',
            'commission' => 'required|numeric',
            'email' => 'required|email|unique:companies,email',
            'status' => 'required|in:active,hidden',
            'number' => 'required|unique:companies,number',
            'contact_person' => 'required',
            'contact_person_number' => 'required|unique:companies,contact_person_number',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $name = $request->input('name');
        $slug = Str::slug($name);
        $address = $request->input('address');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $registration_number = $request->input('registration_number');
        $email = $request->input('email');
        $commission = $request->input('commission');
        $status = $request->input('status');
        $number = $request->input('number');
        $contact_person = $request->input('contact_person');
        $contact_person_number = $request->input('contact_person_number');
        $description = $request->input('description');

        $random = Str::random(8);
        $password = Hash::make($random);

        $logo = $request->file('logo');
        if ($logo) {
            $getuniquename = sha1($logo->getClientOriginalName() . time());
            $getextension = $logo->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $logo->move('site/uploads/company/', $file_name);
        }

        $company = new Company;
        $company->name = $name;
        $company->slug = $slug;
        $company->address = $address;
        $company->longitude = $longitude;
        $company->latitude = $latitude;
        $company->registration_number = $registration_number;
        $company->email = $email;
        $company->email_verified_at = Carbon::now();
        $company->commission = $commission;
        $company->status = $status;
        $company->number = $number;
        $company->contact_person = $contact_person;
        $company->contact_person_number = $contact_person_number;
        $company->description = $description;
        $company->password = $password;
        if ($logo) {
            $company->logo = $file_name;
        }

        $company->save();

        $maildata = [
            'title' => "Your account as a company has been created. You can now login to our website using the following credentials:",
            'subject' => "Your login Credentials",
            'link' => "sitara.my/company/login",
            'linktitle' => "Click here to Login",
            'name' => $name,
            'email' => $email,
            'password' => $random,
        ];

        Mail::send('email.password.send', $maildata, function ($message) use ($maildata) {
            $message->from('noreply.sitara@gmail.com', 'SITARA');
            $message->sender('noreply.sitara@gmail.com', 'SITARA');
            $message->to($maildata['email'], $maildata['name']);
            $message->subject('Your login credentials');
            $message->priority(1);
        });

        return redirect()->back()->with('success', 'Company added successfully! Password is sent to email.');
    }

    public function getManageCompanyEmployee($slug)
    {
        $company = Company::where('slug', $slug)->where('deleted_at', null)->limit(1)->first();

        if (is_null($company)) {
            return redirect()->back()->with('error', 'Company doesnot exists!');
        }

        $data = [
            'company' => $company,
            'slug' => $slug,
        ];

        return view('admin.company.employee.manage', $data);
    }

    public function postAddCompanyEmployee(Request $request, $slug)
    {
        $company = Company::where('slug', $slug)->where('deleted_at', null)->limit(1)->first();

        if (is_null($company)) {
            return redirect()->back()->with('error', 'Company doesnot exists!');
        }

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'employee_id' => 'required|unique:users,employee_id',
            'address' => 'required',
            'ic_number' => 'required',
            'post' => 'required',
            'date_of_birth' => 'required|date',
            'race' => 'required',
            'address' => 'required',
            'per_visit_claim' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:male,female,others',
            'status' => 'required|in:active,hidden',
            'phone_number' => 'required|unique:users,phone_number',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $first_name = $request->input('first_name');
        $middle_name = $request->input('middle_name');
        $last_name = $request->input('last_name');
        $employee_id = $request->input('employee_id');
        $email = $request->input('email');
        $phone_number = $request->input('phone_number');
        $post = $request->input('post');
        $date_of_birth = $request->input('date_of_birth');
        $gender = $request->input('gender');
        $race = $request->input('race');
        $ic_number = $request->input('ic_number');
        $address = $request->input('address');
        $per_visit_claim = $request->input('per_visit_claim');
        $status = $request->input('status');
        $description = $request->input('description');

        $password = Hash::make($ic_number);

        $image = $request->file('image');
        if ($image) {
            $getuniquename = sha1($image->getClientOriginalName() . time());
            $getextension = $image->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $image->move('site/uploads/company/employee/', $file_name);
        }

        $user = new User;
        $user->company_id = $company->id;
        $user->employee_id = $employee_id;
        $user->first_name = $first_name;
        $user->middle_name = $middle_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->email_verified_at = Carbon::now();
        $user->phone_number = $phone_number;
        $user->password = $password;
        $user->post = $post;
        $user->date_of_birth = $date_of_birth;
        $user->gender = $gender;
        $user->race = $race;
        $user->ic_number = $ic_number;
        $user->address = $address;
        $user->per_visit_claim = $per_visit_claim;
        $user->status = $status;
        $user->description = $description;
        if ($image) {
            $user->image = $file_name;
        }

        $user->save();

        $maildata = [
            'title' => "Your account as a company employee has been created. You can now login to our website using the following credentials:",
            'subject' => "Your login Credentials",
            'link' => "sitara.my",
            'linktitle' => "Click here to Login",
            'name' => $last_name,
            'email' => $employee_id,
            'password' => $ic_number,
        ];

        Mail::send('email.password.send', $maildata, function ($message) use ($maildata) {
            $message->from('noreply.sitara@gmail.com', 'SITARA');
            $message->sender('noreply.sitara@gmail.com', 'SITARA');
            $message->to($maildata['email'], $maildata['name']);
            $message->subject('Your login credentials');
            $message->priority(1);
        });

        return redirect()->back()->with('success', 'Employee added successfully!, Password is sent to email.');
    }

    public function getCompanyAccountDetailAjax(Request $request)
    {
        
        $company = Company::findOrFail($request->get('company_id'));
        $monthyear = $request->get('month_year'); // You can also use request input
        $explode = explode('-', $monthyear);
            $month = $explode[1];
            $year = $explode[0];

         $company = Company::distinct()
            ->join('users', 'companies.id', '=', 'users.company_id')
            ->join('appointments', 'users.id', '=', 'appointments.user_id')
            ->join('clinics', 'appointments.clinic_id', '=', 'clinics.id')
            ->join('schedule_times', function ($join) {
                $join->on('appointments.schedule_time_id', '=', 'schedule_times.id')
                    ->orWhere('appointments.reschedule_time_id', '=', 'schedule_times.id');
            })
            ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
            ->where('appointments.status', 'completed')
            ->where(function ($query) use ($month, $year) {
                if ($month) {
                    $query->whereMonth('schedule_dates.date', $month)
                        ->whereYear('schedule_dates.date', $year);
                }
            })
            ->where('companies.deleted_at', null)
            ->select('companies.*')
            ->where('companies.id', $company->id)
            ->first();
            
        
    return view('admin.partials.company_modal', compact('company', 'monthyear'));

    }

    public function getManageCompanyAccount(Request $request)
    {
        // dd($request->all());
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
            ->where('appointments.status', 'completed')
            ->where(function ($query) use ($month, $year) {
                if ($month) {
                    $query->whereMonth('schedule_dates.date', $month)
                        ->whereYear('schedule_dates.date', $year);
                }
            })
            ->where('companies.deleted_at', null)
            ->select('companies.*')
            ->get();
        $data = [
            'companies' => $companies,
            'monthyear' => $sendmonthyear,
        ];

        // return $data;

        return view('admin.company.account.manage', $data);
    }

    public function getClinicAccountDetails(Request $request, $slug)
    {
        $clinic = Clinic::where('slug', $slug)->where('deleted_at', null)->limit(1)->first();

        if (is_null($clinic)) {
            return redirect()->back()->with('error', 'Clinic doesnot exists!');
        }

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
            ->join('users', 'users.company_id', '=', 'companies.id')
            ->join('appointments', 'appointments.user_id', 'users.id')
            ->join('clinics', 'clinics.id', '=', 'appointments.clinic_id')
            ->join('schedule_times', function ($join) {
                $join->on('appointments.schedule_time_id', '=', 'schedule_times.id')
                    ->orWhere('appointments.reschedule_time_id', '=', 'schedule_times.id');
            })
            ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
            ->where('appointments.status', 'completed')
            ->where(function ($query) use ($month, $year) {
                if ($month) {
                    $query->whereMonth('schedule_dates.date', $month)
                        ->whereYear('schedule_dates.date', $year);
                }
            })
            ->where('clinics.deleted_at', null)
            ->where('clinics.id', $clinic->id)
            ->select('clinics.*')
            ->get();

        $data = [
            'clinic' => $clinic,
            'companies' => $companies,
            'monthyear' => $sendmonthyear
        ];

        return view('admin.clinic.account.detail', $data);
    }

    public function getCompanyAccountDetails(Request $request, $slug)
    {
        $company = Company::where('slug', $slug)->where('deleted_at', null)->limit(1)->first();

        if (is_null($company)) {
            return redirect()->back()->with('error', 'Company doesnot exists!');
        }

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

        $clinics = Clinic::distinct()
            ->join('appointments', 'appointments.clinic_id', 'clinics.id')
            ->join('users', 'users.id', '=', 'appointments.user_id')
            ->join('companies', 'companies.id', '=', 'users.company_id')
            ->join('schedule_times', function ($join) {
                $join->on('appointments.schedule_time_id', '=', 'schedule_times.id')
                    ->orWhere('appointments.reschedule_time_id', '=', 'schedule_times.id');
            })
            ->join('schedule_dates', 'schedule_times.schedule_date_id', '=', 'schedule_dates.id')
            ->where('appointments.status', 'completed')
            ->where(function ($query) use ($month, $year) {
                if ($month) {
                    $query->whereMonth('schedule_dates.date', $month)
                        ->whereYear('schedule_dates.date', $year);
                }
            })
            ->where('clinics.deleted_at', null)
            ->where('companies.id', $company->id)
            ->select('clinics.*')
            ->get();

        $data = [
            'company' => $company,
            'clinics' => $clinics,
            'monthyear' => $sendmonthyear
        ];

        return view('admin.company.account.detail', $data);
    }

    public function getDependent($companySlug, $employeID)
    {
        return view("admin.company.employee.dependent", [
            "slug" => $companySlug,
            "id" => $employeID,
            "dependents" => Dependent::where("employee_id", $employeID)->get(),
        ]);
    }

    public function postDependent(Request $request, $companySlug, $employeID)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'dob' => 'required|date',
            'icnumber' => 'nullable|string|max:20',
            'relation' => 'required|string|max:255',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif',
            'min_benefit'   => 'required|numeric|min:0',
        ]);

        $dependent = new Dependent();
        $dependent->employee_id = $employeID;
        $dependent->name = $request->input('name');
        $dependent->gender = $request->input('gender');
        $dependent->dob = $request->input('dob');
        $dependent->icnumber = $request->input('icnumber');
        $dependent->relation = $request->input('relation');
        $dependent->min_benefit = $request->input('min_benefit');

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move('site/uploads/dependent/', $filename);
            $dependent->photo = $filename;
        }

        $dependent->save();
        
        return redirect()->back()->with('success', 'Dependent added successfully!');
    }

    public function deleteDependent($slug, $id, $dependentid) {
        // return $dependentid;
        $dependent = Dependent::findOrFail($dependentid);
        $dependent->delete();

        return redirect()->back()->with('success', 'Dependent deleted successfully!');
    }

    public function statusChangeDependent($slug, $id, $dependentid) {
        $dependent = Dependent::findOrFail($dependentid);
        $dependent->status = $dependent->status == 'active' ? 'inactive' : 'active';
        $dependent->save();

        return redirect()->back()->with('success', 'Dependent status changed successfully!');
    }
public function getpayableBillofMonthPDF(Company $company, Clinic $clinic, $date)
{
    $parsedDate = Carbon::parse($date); // e.g., '2025-06'
    $month = $parsedDate->month;
    $year = $parsedDate->year;

    $appointments = Appointment::with(['user', 'clinic', 'scheduleTime.scheduleDate'])
        ->where('status', 'completed')
        ->whereHas('user', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })
        ->where('clinic_id', $clinic->id)
        ->whereHas('scheduleTime.scheduleDate', function ($query) use ($month, $year) {
            $query->whereMonth('date', $month)
                  ->whereYear('date', $year);
        })
        ->get();
        // dd($company, $clinic, $appointments, $date);
        $pdf = Pdf::loadView('admin.company.account.payable_bill_pdf', [
        'company' => $company,
        'clinic' => $clinic,
        'appointments' => $appointments,
        'date' => $parsedDate->format('F Y'),
    ]);
    return $pdf->stream('Payable_Bill_of_' . $clinic->slug . '_' . $parsedDate->format('m_Y') . '.pdf');
    
}
public function getALLpayableBillofMonthPDF(Company $company, Clinic $clinic, $date)
{
    $parsedDate = Carbon::parse($date);
    $month = $parsedDate->month;
    $year = $parsedDate->year;

    $appointments = Appointment::with(['user', 'clinic', 'scheduleTime.scheduleDate'])
        ->where('status', 'completed')
        ->whereHas('user', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })
        ->whereHas('scheduleTime.scheduleDate', function ($query) use ($month, $year) {
            $query->whereMonth('date', $month)
                  ->whereYear('date', $year);
        })
        ->get();

    $pdf = Pdf::loadView('admin.company.account.all_payable_bill_pdf', [
        'company' => $company,
        'clinic' => $clinic,
        'appointments' => $appointments,
        'date' => $parsedDate->format('F Y'), // e.g., 'June 2025'
    ]);

    return $pdf->stream('All_Payable_Bill_of_'.$company->slug.'_' . $parsedDate->format('m_Y') . '.pdf');
    // Or use ->download(...) to trigger download
}
public function getLinkedClinicOfCompany(Request $request){
    $active_linked_clinics = CompanyClinic::where('company_id', $request->get('company_id'))
    ->whereNotNull('refer_code')
    ->where('status', 'active')
    ->whereNull('deleted_at')
    ->get();
    return view('admin.company.partials.linked_clinic_modal', compact('active_linked_clinics'));
}
public function getLinkedCompanyOfClinic(Request $request){
   
    $active_linked_companies = CompanyClinic::where('clinic_id', $request->get('clinic_id'))
    ->whereNotNull('refer_code')
    ->where('status', 'active')
    ->whereNull('deleted_at')
    ->get();
   
    return view('admin.company.partials.linked_company_modal', compact('active_linked_companies'));
}
       
}
