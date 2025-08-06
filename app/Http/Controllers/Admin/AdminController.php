<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Registrationrequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    use AuthenticatesUsers;
    // *
    //  * Get the path the user should be redirected to when they are not authenticated.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return string|null

    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        if(Auth::guard('admin')->attempt($credentials, $request->remember)){
            $user = Admin::where('email', $request->email)->first();
            Auth::guard('admin')->login($user);
            return redirect()->route('admin.home');
        }
        return redirect()->route('admin.login')->with('fail', 'Invalid Username and Password');
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
        return redirect()->route('admin.home');
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('status','Logout Successfully!');
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }
    public function getRegistrationRequestList(){
        $data =[
            'lists' => Registrationrequest::where('status', 'P')->get()
        ];
        return view('admin.registerrequest.manage', $data);
    }
    public function getProfile(){
        $data =[
            'admin' => Admin::find(Auth()->user()->id)
        ];
        return view('admin.profile.index', $data);
    }
    public function postUpdateProfile(Request $request){
        $admin = Admin::find(Auth()->user()->id);

        $admin->name = $request->input('name');
        if($request->input('password') != Null){
            $password = $request->input('password');
            $admin->password = Hash::make($password);
        }
        $admin->save();
        return redirect()->back()->with('success', 'Profile Updated Successfully');

    }
    
}
