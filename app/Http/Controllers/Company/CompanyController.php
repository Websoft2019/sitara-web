<?php

namespace App\Http\Controllers\Company;

use App\Models\Company;
use App\Models\Registrationrequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CompanyController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        $testCompanyExistOrNot = Company::where('email', $request->email)->where('deleted_at', null)->first();
        if ($testCompanyExistOrNot === null) {
            return redirect()->route('company.login')->with('fail', 'Invalid Username and Password');
        }

        if(Auth::guard('company')->attempt($credentials, $request->remember)){
            $user = Company::where('email', $request->email)->where("deleted_at", null)->first();
            if ($user === null) {
                return redirect()->route('company.login')->with('fail', 'Invalid Username and Password');
            }
            Auth::guard('company')->login($user);
            return redirect()->route('company.home');
        }
        return redirect()->route('company.login')->with('fail', 'Invalid Username and Password');
    }
    public function showLinkRequestForm(){
        return view('auth.company.passwords.email');
    }
    public function sendResetLinkEmail(Request $request){
        $email = $request->input('email');
        

        $check = Company::where('email', $email)->limit(1)->first();
        if($check){
            if($check->status == 'active'){
                // save token
                $token = sha1(time());
                Company::where('email', $email)->limit(1)->update(array('remember_token' => $token, 'email_verified_at' => Carbon::now()));
                // send email
                $maildata = [
                    
                    'subject' => "Sitara Company Panel Password Reset Link :: Sitara",
                    'link' => "https://sitara.my/company/password/reset/".$token,
                    
                    'name' => $check->name,
                    'email' => $check->email,
                ];
                Mail::send('email.company.resetpassword', $maildata, function ($message) use ($maildata) {
                    $message->from('noreply.sitara@gmail.com', 'SITARA');
                    $message->sender($maildata['email'], $maildata['name']);
                    $message->to($maildata['email'], $maildata['name']);
                   $message->subject($maildata['subject']);
                   $message->priority(1);
                 });
                 return redirect()->back()->with('status', 'Password Reset Link has been send in your email');
            }
            else{
                return redirect()->back()->with('fail', 'Your account not active');
            }
        }
        else{
            return redirect()->back()->with('fail', 'We cant find a user with that email address.');
        }
    }
    public function showResetForm($token){
        
        $check = Company::where('remember_token', $token)->limit(1)->first();
        if($check){
            $currenttime = Carbon::now();
            $sendtime = Carbon::parse($check->email_verified_at);
            $differenttime = $sendtime->diff($currenttime);
            if($differenttime->h == 0){
                $data =[
                    'token' => $token
                ];
                return view('auth.company.passwords.reset', $data);
            }
            else{
                return redirect()->route('company.password.request')->with('fail', 'Your password link has been expired');
            }
        }
        else{
            abort(404);
        }
    }
    public function reset(Request $request){
        $this->validate($request, [
            'token' => 'required',
            'email' => 'email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);

        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('password');
        $en_password = Hash::make($password);
        $check = Company::where('email', $email)->where('remember_token', $token)->limit(1)->first();
        if($check){
            Company::where('email', $email)->where('remember_token', $token)->limit(1)->update(array('password' => $en_password, 'remember_token'=> Null));
            return redirect()->route('company.login')->with('status', 'Your password reset successfully. Login with new password!');
        }
        else{
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
        return redirect()->route('company.home');
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('company');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */

    public function logout(){
        Auth::guard('company')->logout();
        return redirect()->route('company.login')->with('status','Logout Successfully!');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('company.login');
    }
    public function dashboard(){
        return view('company.home');
    }
    public function register(){
        return view('company.register');
    }
    public function postRegisterRequest(Request $request){
        $request->validate([
            'name' => 'required|unique:companies,name',
            'address' => 'required',
            'registration_number' => 'required|unique:companies,registration_number',
            'email' => 'required|email|unique:companies,email',
            'contactperson' => 'required',
            'phone' => 'required|unique:companies,contact_person_number',
        ]);
        $name = $request->input('name');
        $address = $request->input('address');
        $registration_number = $request->input('registration_number');
        $email = $request->input('email');
        $contact_person = $request->input('contactperson');
        $contact_person_number = $request->input('phone');

    
        $company = new Registrationrequest;
        $company->name = $name;
        $company->type = 'company';
        $company->address = $address;
        $company->registration_number = $registration_number;
        $company->email = $email;
        $company->contactperson = $contact_person;
        $company->contact_person_number = $contact_person_number;
        $company->company_contact_number = $contact_person_number;
        $company->city = $request->input('city');
        $company->state = $request->input('state');
        $company->postalcode = $request->input('postalcode');
        $company->save();
        return redirect()->back()->with('success', 'Company registration request send successfully');
    }
    public function postRegister(Request $request){
        $request->validate([
            'name' => 'required|unique:companies,name',
            'address' => 'required',
            'registration_number' => 'required|unique:companies,registration_number',
            'email' => 'required|email|unique:companies,email',
            'contactperson' => 'required',
            'phone' => 'required|unique:companies,contact_person_number',
        ]);

        $name = $request->input('name');
        $slug = Str::slug($name);
        $address = $request->input('address');
        $registration_number = $request->input('registration_number');
        $email = $request->input('email');
        $number = $request->input('phone');
        $contact_person = $request->input('contactperson');
        $contact_person_number = $request->input('phone');

        $random = Str::random(8);
        $password = Hash::make($random);

    
        $company = new Company;
        $company->name = $name;
        $company->slug = $slug;
        $company->address = $address;
        $company->commission = '0';
        $company->registration_number = $registration_number;
        $company->email = $email;
        $company->email_verified_at = Carbon::now();
        
        $company->number = $number;
        $company->contact_person = $contact_person;
        $company->contact_person_number = $contact_person_number;
        $company->password = $password;
        

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

        return redirect()->back()->with('success', 'Company registration successfully! Password is sent to email.');
    }
    public function getProfile(){
        return view('company.profile');
    }
    public function postUpdateProfile(Request $request){
        $request->validate([
            'address' => 'required',
            'longitude' => 'required',
            'number' => 'required',
            'contact_person' => 'required',
            'contact_person_number' => 'required',


        ]);
        if($request->input('password') != Null){
            $request->validate([
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6',
            ]);
        }
        $image = $request->file('logo');
        $company= Company::find(Auth()->user()->id);
        $company->name = $request->input('name');
        if($image != Null){
            $getuniquename = sha1($image->getClientOriginalName() . time());
            $getextension = $image->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $image->move('site/uploads/company/', $file_name);
            $company->logo = $file_name;
        }
        $company->address = $request->input('address');
        $company->longitude = $request->input('longitude');
        $company->latitude = $request->input('latitude');
        $company->number = $request->input('number');
        $company->contact_person = $request->input('contact_person');
        $company->contact_person_number = $request->input('contact_person_number');
        $company->description = $request->input('description');
        if($request->input('password')){
            $company->password = Hash::make($request->input('password'));
        }
        $company->save();
        return redirect()->back()->with('success', 'Company profile updated successfully.');

    }
}
