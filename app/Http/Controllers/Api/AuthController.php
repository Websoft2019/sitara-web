<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:users,employee_id',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors(), 400);
        }
        if (Auth::attempt(['employee_id' => $request->input('employee_id'), 'password' => $request->input('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('SITARA')->accessToken;
            $success['is_first_login'] =  $user->is_first_login;

            return $this->sendResponse($success, 'User Login successfully.');
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Credentials doesnot match.']);
        }
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors(), 400);
        }

        $user = User::find(Auth::user()->id);
        if($user->is_first_login == "yes"){
            $password = $request->input('password');

            $user->password = Hash::make($password);
            $user->is_first_login = "no";
            $user->save();

            return $this->sendResponse(null, 'Password Updated Successfully!');
        }
        else{
            return $this->sendError('Method not allowed!', 'Method not allowed!', 405);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => ['required', 'same:confirm_new_password'],
            'confirm_new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors(), 400);
        }

        $user = User::find(Auth::user()->id);
        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');
        // Check if the current password is correct
        if (!Hash::check($current_password, $user->password)) {
            return $this->sendError('Current password doesnot matched', 'Current password doesnot matched', 401);
        }

        if ($current_password == $new_password) {
            return $this->sendError('Current password and New password cant be same', 'Current password and New password cant be same', 401);
        }

        $user->password = Hash::make($new_password);
        $user->save();

        return $this->sendResponse(null, 'Password Change Successfully!');
    }
}
