<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\User\Profile as ProfileResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class ProfileController extends BaseController
{
    public function getProfileOfMe(Request $request)
    {
        return $this->sendResponse(new ProfileResource(Auth::user()), 'Profile fetched successfully');
    }

    public function postImageUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors(), 400);
        }

        $user = User::find(Auth::user()->id);

        $image = $request->file('image');
        if ($image) {
            $getuniquename = sha1($image->getClientOriginalName() . time());
            $getextension = $image->getClientOriginalExtension();
            $file_name = $getuniquename . '.' . $getextension;
            $image->move('site/uploads/company/employee/', $file_name);
            if ($user->image) {
                unlink('site/uploads/company/employee/' . $user->image);
            }
        }

        $user->image = $file_name;

        $user->save();
        return $this->sendResponse(null, 'Image updated succesfully!');
    }
}
