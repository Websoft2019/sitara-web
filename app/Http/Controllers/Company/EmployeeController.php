<?php

namespace App\Http\Controllers\Company;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompanyClinic;
use App\Http\Controllers\Controller;
use App\Imports\EmployeeImport;
use App\Models\Clinic;
use App\Models\Company;
use App\Models\Dependent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class EmployeeController extends Controller
{
    public function getEmployeeManage()
    {
        $data = [
            'company' => Auth::user(),
        ];
        return view('company.employee.manage', $data);
    }

    public function getDeleteEmployee($employee_id)
    {
        $employee = User::where('employee_id', $employee_id)->where('deleted_at', null)->limit(1)->first();
        if (is_null($employee)) {
            return redirect()->back()->with('error', 'Employee doesnot exists.!');
        }

        $employee->deleted_at = Carbon::now();
        $employee->save();

        return redirect()->back()->with('success', 'Employee deleted successfully!');
    }

    public function getEditEmployee($employee_id)
    {
        $employee = User::where('employee_id', $employee_id)->where('deleted_at', null)->limit(1)->first();
        if (is_null($employee)) {
            return redirect()->back()->with('error', 'Employee doesnot exists.!');
        }

        $data = [
            'employee' => $employee
        ];

        return view('company.employee.edit', $data);
    }

    public function getSendPasswordOfEmployee($employee_id)
    {
        $employee = User::where('employee_id', $employee_id)->where('deleted_at', null)->limit(1)->first();
        if (is_null($employee)) {
            return redirect()->back()->with('error', 'Employee doesnot exists.!');
        }

        $random = Str::random(8);
        $password = Hash::make($random);

        $employee->password = $password;
        $employee->is_first_login = "yes";
        $employee->save();

        if ($employee->email != null) {
            $maildata = [
                'title' => "Your account as a company employee has been updated. You can now login to our website using the following credentials:",
                'subject' => "Your login Credentials",
                'link' => "sitara.my/login",
                'linktitle' => "Click here to Login",
                'name' => $employee->last_name,
                'email' => $employee_id,
                'password' => $random,
            ];

            Mail::send('email.password.employeesend', $maildata, function ($message) use ($maildata, $employee) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender('noreply.sitara@gmail.com', 'SITARA');
                $message->to($employee->email, $maildata['name']);
                $message->subject('Your login credentials');
                $message->priority(1);
            });
            return redirect()->back()->with('success', 'Employee password has been sent to email.');
        } else {
            return redirect()->back()->with('error', 'Employee doesnot have email linked.!');
        }
    }

    public function postEditEmployee(Request $request, $employee_id)
    {
        $employee = User::where('employee_id', $employee_id)->where('deleted_at', null)->limit(1)->first();
        if (is_null($employee)) {
            return redirect()->route('company.getEmployeeManage')->with('error', 'Employee doesnot exists.!');
        }

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'employee_id' => 'required',
            'address' => 'required',
            'ic_number' => 'required',
            'post' => 'required',
            'date_of_birth' => 'required|date',
            'race' => 'required',
            'address' => 'required',
            'per_visit_claim' => 'required|numeric',
            'gender' => 'required|in:male,female,others',
            'status' => 'required|in:active,hidden',
            'phone_number' => 'required|unique:users,phone_number,' . $employee->id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);
        $employee_id = $request->input('employee_id');
        $company = Auth::user();

        if (str_starts_with($employee_id, $company->id . '-')) {
            $employee_id = $request->employee_id;
        } else {
            $employee_id = $request->input('employee_id');
            $company = Auth::user();
            $employee_id = $company->id . '-' . $employee_id;
        }

        $first_name = $request->input('first_name');
        $middle_name = $request->input('middle_name');
        $last_name = $request->input('last_name');
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

        $image = $request->file('image');
        if ($image) {
            $getuniquename = sha1($image->getClientOriginalName() . time());
            $getextension = $image->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $image->move('site/uploads/company/employee/', $file_name);

            if ($employee->image) {
                unlink('site/uploads/company/employee/' . $employee->image);
            }
        }

        $employee->employee_id = $employee_id;
        $employee->first_name = $first_name;
        $employee->middle_name = $middle_name;
        $employee->last_name = $last_name;
        $employee->email = $email;
        $employee->phone_number = $phone_number;
        $employee->post = $post;
        $employee->date_of_birth = $date_of_birth;
        $employee->gender = $gender;
        $employee->race = $race;
        $employee->ic_number = $ic_number;
        $employee->address = $address;
        $employee->per_visit_claim = $per_visit_claim;
        $employee->status = $status;
        $employee->description = $description;
        if ($image) {
            $employee->image = $file_name;
        }

        $employee->save();

        return redirect()->route('company.getEmployeeManage')->with('success', 'Employee details updated successfully!');
    }

    public function postAddEmployee(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'employee_id' => 'required',
            'address' => 'required',
            'ic_number' => 'required',
            'post' => 'required',
            'email' =>   'required|unique:users,email',
            'date_of_birth' => 'required|date',
            'race' => 'required',
            'address' => 'required',
            'per_visit_claim' => 'required|numeric',
            'gender' => 'required|in:male,female,others',
            'status' => 'required|in:active,hidden',
            'phone_number' => 'required|unique:users,phone_number',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $employee_id = $request->input('employee_id');
        $company = Auth::user();

        if (str_starts_with($employee_id, $company->id . '-')) {
            $employee_id = $request->employee_id;
        } else {
            $employee_id = $request->input('employee_id');
            $company = Auth::user();
            $employee_id = $company->id . '-' . $employee_id;
        }


        $first_name = $request->input('first_name');
        $middle_name = $request->input('middle_name');
        $last_name = $request->input('last_name');
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
        $user->company_id = Auth::user()->id;
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

        if ($email != null) {
            $maildata = [
                'title' => "Your account as a company employee has been created. You can now login to our website using the following credentials:",
                'subject' => "Your login Credentials",
                'link' => "sitara.my/login",
                'linktitle' => "Click here to Login",
                'name' => $last_name,
                'email' => $employee_id,
                'sendemail' => $email,
                'password' => $ic_number,
            ];

            Mail::send('email.password.employeesend', $maildata, function ($message) use ($maildata) {
                $message->from('noreply.sitara@gmail.com', 'SITARA');
                $message->sender('noreply.sitara@gmail.com', 'SITARA');
                $message->to($maildata['sendemail'], $maildata['name']);
                $message->subject('Your login credentials');
                $message->priority(1);
            });

            return redirect()->back()->with('success', 'Employee added successfully!, Password has been sent to email.');
        } else {
            return redirect()->back()->with('success', 'Employee added successfully!');
        }
    }

    public function postImportEmployee(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'excelfile' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);
        
        $excelfile = $request->file('excelfile');
        
        // Create an instance of the import class
        $import = new EmployeeImport;
        
        // Import the file
        Excel::import($import, $excelfile);

        // Get the list of duplicate entries
        $duplicateEntries = $import->getDuplicateEntries();

        if (!empty($duplicateEntries)) {
            // Generate PDF for duplicate entries
            $pdf = PDF::loadView('pdf.duplicate-emails', compact('duplicateEntries'));
            
            // Define the path for the PDF file in the public directory
            $pdfPath = public_path('duplicate_emails.pdf');
            
            // Store the PDF file
            $pdf->save($pdfPath);

            // Generate a download URL
            $downloadUrl = asset('duplicate_emails.pdf');

            // Pass the URL to the frontend
            return redirect()->back()->with([
                'success' => 'Employee imported successfully!',
                'pdfUrl' => $downloadUrl
            ]);
        }

        // If no duplicates, return success message
        return redirect()->back()->with('success', 'Employee imported successfully!');
    }

    public function getManageClinics()
    {
        $data = [
            'company' => Auth::user()
        ];

        return view('company.clinic.manage', $data);
    }

    public function getGenerateReferCode()
    {
        $code = new CompanyClinic;
        $code->company_id = Auth::user()->id;
        $code->refer_code = $this->generateCode();
        $code->request_company_id = Auth::user()->id;
        $code->request_clinic_id = Null;
        $code->status = 'hidden';
        $code->save();
        return redirect()->back()->with('success', 'Refer Code generated successfully.!');
    }

    public function generateCode()
    {
        $refer_code = Str::random(10);
        $check = CompanyClinic::where('refer_code', $refer_code)->limit(1)->first();
        if (is_null($check)) {
            return $refer_code;
        } else {
            $refer_code = $this->generateCode();
        }
    }

    public function getDeleteReferCode($refer_code)
    {
        // $check = CompanyClinic::where('refer_code', $refer_code)->where('company_id', Auth::user()->id)->where('clinic_id', null)->limit(1)->first();
        $check = CompanyClinic::where('refer_code', $refer_code)->where('company_id', Auth::user()->id)->limit(1)->first();
        if (is_null($check)) {
            return redirect()->back()->with('error', 'Refer Code Invalid.!');
        } else {
            // $check->delete();
            $check->deleted_at = Carbon::now();
            $check->company_id = Null;
            $check->save();

            return redirect()->back()->with('success', 'Refer Code deleted successfully.!');
        }
    }

    public function sendReferCodetoClinic(Request $request, $code)
    {

        $check1 = CompanyClinic::where('refer_code', $code)->where('company_id', Auth::user()->id)->where('clinic_id', null)->limit(1)->first();
        if (is_null($check1)) {

            return redirect()->back()->with('error', 'Refer Code Invalid.!');
        }


        $request->validate([
            'company' => 'required'
        ]);


        $email1 = $request->input('company');
        $email2 = Clinic::find($email1);

        $email = $email2->email;

        $clinic = Clinic::where('email', $email)->where('deleted_at', null)->limit(1)->first();

        if (is_null($clinic)) {
            return redirect()->back()->with('error', 'Clinic email invalid!');
        } else {
            $check2 = CompanyClinic::where('company_id', Auth::user()->id)->where('clinic_id', $clinic->id)->limit(1)->first();
            if (is_null($check2)) {

                $maildata = [
                    'title' => "A company wants to connect with you use the following refer code to connect:",
                    'subject' => "Company Request",
                    'link' => "sitara.my/clinic/company",
                    'linktitle' => "Click here to go that link",
                    'name' => $clinic->name,
                    'email' => $email,
                    'company_email' => Auth::user()->email,
                    'company_name' => Auth::user()->name,
                    'refer_code' => $code,
                ];

                Mail::send('email.company.refercode', $maildata, function ($message) use ($maildata) {
                    $message->from('noreply.sitara@gmail.com', 'SITARA');
                    $message->sender($maildata['company_email'], $maildata['company_name']);
                    $message->to($maildata['email'], $maildata['name']);
                    $message->subject('Company Request');
                    $message->priority(1);
                });

                CompanyClinic::where('refer_code', $code)->limit(1)->update(array('request_clinic_id' => $email2->id));
                return redirect()->back()->with('success', 'Refer Code sent to email!');
            } else {

                return redirect()->back()->with('error', 'Clinic already connected!');
            }
        }
    }
    public function getCompanyFromReferCode(Request $request)
    {
        $refer_code = $request->refer_code;
        $companyclinic = CompanyClinic::where('refer_code', $refer_code)->where('company_id', null)->limit(1)->first();
        $clinicinfo = Clinic::find($companyclinic->clinic_id);
        // dd($clinicinfo);
        if (is_null($companyclinic)) {
            $response = [
                'success' => false,
            ];
        } else {
            $response = [
                // 'success' => true,
                // 'name' => $companyclinic->getCompanyFromCompanyClinic->name,
                // 'logo' => $companyclinic->getCompanyFromCompanyClinic->logo,
                // 'address' => $companyclinic->getCompanyFromCompanyClinic->address,
                // 'number' => $companyclinic->getCompanyFromCompanyClinic->number,
                // 'contact_person' => $companyclinic->getCompanyFromCompanyClinic->contact_person,
                // 'contact_person_number' => $companyclinic->getCompanyFromCompanyClinic->contact_person_number,
                // 'email' => $companyclinic->getCompanyFromCompanyClinic->email,
                // 'employee_count' => $companyclinic->getCompanyFromCompanyClinic->getEmployeesFromCompany ? $companyclinic->getCompanyFromCompanyClinic->getEmployeesFromCompany->count() : 0,

                'success' => true,
                'name' => $clinicinfo->name,
                'logo' => $clinicinfo->logo,
                'address' => $clinicinfo->address,
                'number' => $clinicinfo->number,
                'contact_person' => $clinicinfo->contact_person,
                'contact_person_number' => $clinicinfo->contact_person_number,
                'email' => $clinicinfo->email,
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

        $companyclinic = CompanyClinic::where('refer_code', $refer_code)->where('company_id', null)->limit(1)->first();


        if (is_null($companyclinic)) {
            return redirect()->back()->with('error', 'Clinic with this refer_code not available!');
        } else {
            $check = CompanyClinic::where('company_id', $companyclinic->company_id)->where('clinic_id', Auth::user()->id)->limit(1)->first();

            if (is_null($check)) {
                $companyclinic->company_id = Auth::user()->id;
                $companyclinic->save();

                return redirect()->back()->with('success', 'Clinic added successfully!');
            } else {
                return redirect()->back()->with('error', 'Clinic already added!');
            }
        }
    }
    public function getAjaxEmployeeDetail(Request $request)
{
    $emp_id = $request->get('emp_id');
    $employee = User::where('employee_id', $emp_id)->first();

    if (!$employee) {
        return response()->json(['error' => 'Employee not found.'], 404);
    }

    $company = Company::find($employee->company_id);
    $companyName = $company ? $company->name : 'N/A';

    $dependents = Dependent::where('employee_id', $employee->id)->get();

    $data = '';
    foreach ($dependents as $dependent) {
        $photoPath = $dependent->photo
            ? asset('site/uploads/dependent/' . $dependent->photo)
            : asset('site/uploads/dependent/dummy.jpg');

        $photo = '<img src="' . $photoPath . '" alt="" class="img-fluid">';

        $data .= '<div class="row">
                    <div class="col-md-4 col-xxl-3">
                        <div class="box-body-image">' . $photo . '</div>
                    </div>
                    <div class="col-md-8">
                        <b>Name: </b>' . htmlspecialchars($dependent->name) . '<br>
                        <b>Relation: </b>' . htmlspecialchars($dependent->relation) . '<br>
                        <b>IC: </b>' . htmlspecialchars($dependent->icnumber) . '<br>
                        <b>DOB/Gender: </b>' . htmlspecialchars($dependent->dob) . ' (' . htmlspecialchars($dependent->gender) . ')<br>
                        <b>Benifit: </b> RM' . htmlspecialchars($dependent->min_benefit) .'<br />
                        <b>Status: </b>' . htmlspecialchars($dependent->status) . '<br>
                    </div>
                </div><hr />';
    }

    return response()->json([
        'employeeImage' => asset('site/uploads/company/employee/' . $employee->image),
        'employeeName' => trim($employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name),
        'employeeID' => $employee->employee_id,
        'employeeAddress' => $employee->address,
        'employeeEmail' => $employee->email,
        'employeeContactnumber' => $employee->phone_number,
        'employeeVisitclaim' => $employee->per_visit_claim,
        'employeeCompany' => $companyName,
        'dependentLists' => $data
    ]);
}

}
