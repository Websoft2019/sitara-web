<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Clinic;
use App\Models\ClinicUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendPasswordMail;
use App\Http\Controllers\Controller;
use App\Models\Registrationrequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ClinicController extends Controller
{
    public function getManageClinic()
    {
        $data = [
            'clinics' => Clinic::where('deleted_at', null)->get()
        ];
        return view('admin.clinic.manage', $data);
    }

    public function getDeleteClinic($slug)
    {
        $clinic = Clinic::where('slug', $slug)->where('deleted_at', null)->limit(1)->first();

        if (is_null($clinic)) {
            return redirect()->back()->with('error', 'Clinic doesnot exists!');
        }

        $clinic->deleted_at = Carbon::now();
        $clinic->save();

        return redirect()->back()->with('sucess', 'Clinic deleted successfully!');
    }

    public function getEditClinic($slug)
    {
        $clinic = Clinic::where('deleted_at', null)->where('slug', $slug)->limit(1)->first();
        if (is_null($clinic)) {
            return redirect()->back()->with('error', 'Clinic doesnot exists!');
        }

        $data = [
            'clinic' => $clinic,
        ];

        return view('admin.clinic.edit', $data);
    }

    public function postEditClinic(Request $request, $slug)
    {
        $clinic = Clinic::where('deleted_at', null)->where('slug', $slug)->limit(1)->first();
        if (is_null($clinic)) {
            return redirect()->route('admin.getManageClinic')->with('error', 'Clinic doesnot exists!');
        }

        $request->validate([
            'name' => 'required|unique:clinics,name,' . $clinic->id,
            'address' => 'required',
            'registration_number' => 'required|unique:clinics,registration_number,' . $clinic->id,
            'longitude' => 'required',
            'latitude' => 'required',
            'email' => 'required|email|unique:clinics,email,' . $clinic->id,
            'status' => 'required|in:active,hidden',
            'number' => 'required|unique:clinics,number,' . $clinic->id,
            'contact_person' => 'required',
            'contact_person_number' => 'required|unique:clinics,contact_person_number,' . $clinic->id,
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $name = $request->input('name');
        $slug = Str::slug($name);
        $address = $request->input('address');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $registration_number = $request->input('registration_number');
        $email = $request->input('email');
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
            $logo->move('site/uploads/clinic/', $file_name);

            if ($clinic->logo) {
                unlink('site/uploads/clinic/' . $clinic->logo);
            }
        }

        $clinic->name = $name;
        $clinic->slug = $slug;
        $clinic->address = $address;
        $clinic->longitude = $longitude;
        $clinic->latitude = $latitude;
        $clinic->registration_number = $registration_number;
        $clinic->email = $email;
        $clinic->status = $status;
        $clinic->number = $number;
        $clinic->contact_person = $contact_person;
        $clinic->contact_person_number = $contact_person_number;
        $clinic->description = $description;
        if ($logo) {
            $clinic->logo = $file_name;
        }
        $clinic->save();
        return redirect()->route('admin.getManageClinic')->with('success', 'Clinic details edited successfully!.');
    }

    public function postAddClinic(Request $request)
    {
        //dd('sdfsdf');
        $request->validate([
            'name' => 'required|unique:clinics,name',
            'address' => 'required',
            'registration_number' => 'required',
            'email' => 'required|email|unique:clinics,email',
            'status' => 'required|in:active,hidden',
            'number' => 'required',
            'contact_person' => 'required',
            'contact_person_number' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $name = $request->input('name');
        $slug = Str::slug($name);
        $address = $request->input('address');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $registration_number = $request->input('registration_number');
        $email = $request->input('email');
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
            $logo->move('site/uploads/clinic/', $file_name);
        }

        $clinic = new Clinic;
        $clinic->name = $name;
        $clinic->slug = $slug;
        $clinic->address = $address;
        $clinic->longitude = $longitude;
        $clinic->latitude = $latitude;
        $clinic->registration_number = $registration_number;
        $clinic->email = $email;
        $clinic->status = $status;
        $clinic->number = $number;
        $clinic->contact_person = $contact_person;
        $clinic->contact_person_number = $contact_person_number;
        $clinic->description = $description;
        if ($logo) {
            $clinic->logo = $file_name;
        }
        $clinic->save();
        if($request->input('way') == 'approved'){
            Registrationrequest::where('id', $request->input('registration_id'))->limit(1)->update(array('status' => 'A'));
            //auto add username of clinic
            $name = $clinic->name;
            $email = $clinic->email;
            $random = Str::random(8);
            $password = Hash::make($random);
    
            $user = new ClinicUser;
            $user->clinic_id = $clinic->id;
            $user->name = $name;
            $user->email = $email;
            $user->password = $password;
            $user->email_verified_at = Carbon::now();
            $user->status = 'active';
            $user->role = 'admin';
            $user->save();
    
            $maildata = [
                'title' => "Your account Admin has been created. You can now login to our website using the following credentials:",
                'subject' => "Your login Credentials",
                'link' => "https://sitara.my/clinic/login",
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
    
        }
        return redirect()->back()->with('success', 'Clinic added successfully!.');
    }

    public function getManageClinicUser($slug)
    {
        $clinic = Clinic::where('deleted_at', null)->where('slug', $slug)->limit(1)->first();
        if (is_null($clinic)) {
            return redirect()->back()->with('error', 'Clinic doesnot exists!');
        }

        $data = [
            'clinic' => $clinic,
        ];

        return view('admin.clinic.user.manage', $data);
    }

    public function postAddClinicUser(Request $request, $slug)
    {
        $clinic = Clinic::where('deleted_at', null)->where('slug', $slug)->limit(1)->first();
        if (is_null($clinic)) {
            return redirect()->back()->with('error', 'Clinic doesnot exists!');
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clinic_users,email',
            'status' => 'required|in:active,hidden',
            'role' => 'required|in:admin,doctor',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $status = $request->input('status');
        $role = $request->input('role');
        $description = $request->input('description');

        $random = Str::random(8);
        $password = Hash::make($random);

        $image = $request->file('image');
        if ($image) {
            $getuniquename = sha1($image->getClientOriginalName() . time());
            $getextension = $image->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $image->move('site/uploads/clinic/user', $file_name);
        }

        $user = new ClinicUser;
        $user->clinic_id = $clinic->id;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->email_verified_at = Carbon::now();
        $user->status = $status;
        $user->role = $role;
        $user->description = $description;
        if ($image) {
            $user->image = $file_name;
        }

        $user->save();

        $maildata = [
            'title' => "Your account (" . $role . ") has been created. You can now login to our website using the following credentials:",
            'subject' => "Your login Credentials",
            'link' => "sitara.my/clinic/login",
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

        return redirect()->back()->with('success', 'Clinic user added successfully, Password was sent to users email.!');
    }

    public function getSendPasswordForClinicUser($id)
    {
        $user = ClinicUser::where('id', $id)->where('deleted_at', null)->limit(1)->first();
        if (is_null($user)) {
            return redirect()->back()->with('error', 'Clinic user doesnot exists.');
        }

        $random = Str::random(8);
        $password = Hash::make($random);

        $user->password = $password;
        $user->is_first_login = "yes";
        $user->save();

        $maildata = [
            'title' => "Your account password has been updated. You can now login to our website using the following credentials:",
            'subject' => "Your login Credentials",
            'link' => "sitara.my/clinic/login",
            'linktitle' => "Click here to Login",
            'name' => $user->name,
            'email' => $user->email,
            'password' => $random,
        ];

        Mail::send('email.password.send', $maildata, function ($message) use ($maildata) {
            $message->from('noreply.sitara@gmail.com', 'SITARA');
            $message->sender('noreply.sitara@gmail.com', 'SITARA');
            $message->to($maildata['email'], $maildata['name']);
            $message->subject('Your login credentials');
            $message->priority(1);
        });

        return redirect()->back()->with('success', 'Password was sent to users email.!');
    }

    public function getDeleteClinicUser($id)
    {
        $user = ClinicUser::where('id', $id)->where('deleted_at', null)->limit(1)->first();
        if (is_null($user)) {
            return redirect()->back()->with('error', 'Clinic user doesnot exists.');
        }

        $user->deleted_at = Carbon::now();
        $user->save();

        return redirect()->back()->with('success', 'Clinic user deleted successfully!');
    }

    public function postEditClinicUser(Request $request, $id)
    {
        $user = ClinicUser::where('id', $id)->where('deleted_at', null)->limit(1)->first();
        if (is_null($user)) {
            return redirect()->back()->with('error', 'Clinic user doesnot exists.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clinic_users,email,' . $user->id,
            'status' => 'required|in:active,hidden',
            'role' => 'required|in:admin,doctor',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $status = $request->input('status');
        $role = $request->input('role');
        $description = $request->input('description');

        $image = $request->file('image');
        if ($image) {
            $getuniquename = sha1($image->getClientOriginalName() . time());
            $getextension = $image->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $image->move('site/uploads/clinic/user/', $file_name);

            if ($user->image) {
                unlink('site/uploads/clinic/user/' . $user->image);
            }
        }

        $user->name = $name;
        $user->email = $email;
        $user->status = $status;
        $user->role = $role;
        $user->description = $description;
        if ($image) {
            $user->image = $file_name;
        }

        $user->save();
        return redirect()->back()->with('success', 'User details edited successfully!');
    }

    public function getManageClinicAccount(Request $request)
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

        $clinics = Clinic::distinct()
            ->join('appointments', 'clinics.id', '=', 'appointments.clinic_id')
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
            ->select('clinics.*')
            ->get();

        // dd($clinics);
        $data = [
            'clinics' => $clinics,
            'monthyear' => $sendmonthyear
        ];

        return view('admin.clinic.account.manage', $data);
    }
}
