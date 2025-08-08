<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Clinic;
use App\Models\Company;
use App\Models\ScheduleDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use App\Http\Resources\Home\Clinic as ClinicResource;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\Home\ClinicDetail as ClinicDetailResource;
use App\Http\Resources\Schedule\ScheduleDate as ScheduleDateResource;

class HomeController extends BaseController
{
    public function getHomeContents(Request $request)
    {
        $size = $request->size ?? 10;

        $ip_address = $this->getIp();

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $company = Company::find(Auth::user()->getCompanyFromUser->id);

        if ($latitude == null || $longitude == null) {
            if ($position = Location::get($ip_address)) {
                $latitude = $position->latitude; // replace with user's current latitude
                $longitude = $position->longitude; // replace with user's current longitude

                $clinics = $company->getClinicsFromCompany()
                    ->select(['*', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(latitude)))) AS distance')])
                    ->where('company_clinics.deleted_at', null) // specify which table's deleted_at column to use
                    ->where('company_clinics.status', 'active')
                    ->orderBy('distance')
                    ->paginate($size);
            } else {
                $clinics = $company->getClinicsFromCompany()
                    ->paginate($size);
            }
        } else {
            $clinics = $company->getClinicsFromCompany()
                ->select(['*', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(latitude)))) AS distance')])
                ->where('company_clinics.deleted_at', null) // specify which table's deleted_at column to use
                ->where('company_clinics.status', 'active')
                ->orderBy('distance')
                ->paginate($size);
        }
        return $this->sendResponse(['clinics' => ClinicResource::collection($clinics)], 'Nearest Clinics Fetched.');
    }

    public function getClinics(Request $request)
    {
        $size = $request->size ?? 10;

        $ip_address = $this->getIp();

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $company = Company::find(Auth::user()->getCompanyFromUser->id);

        if ($latitude == null || $longitude == null) {
            if ($position = Location::get($ip_address)) {
                $latitude = $position->latitude; // replace with user's current latitude
                $longitude = $position->longitude; // replace with user's current longitude

                $clinics = $company->getClinicsFromCompany()
                    ->select(['*', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(latitude)))) AS distance')])
                    ->where('company_clinics.deleted_at', null) // specify which table's deleted_at column to use
                    ->where('company_clinics.status', 'active')
                    ->orderBy('distance')
                    ->paginate($size);
            } else {
                $clinics = $company->getClinicsFromCompany()
                    ->paginate($size);
            }
        } else {
            $clinics = $company->getClinicsFromCompany()
                ->select(['*', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(latitude)))) AS distance')])
                ->where('company_clinics.deleted_at', null) // specify which table's deleted_at column to use
                ->where('company_clinics.status', 'active')
                ->orderBy('distance')
                ->paginate($size);
        }

        return $this->sendResponse(ClinicResource::collection($clinics)->response()->getData(true), 'Nearest Clinics Fetched');
    }


    public function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }

    public function getClinicDetails($id)
    {
        $clinic = Clinic::where('id', $id)->where('status', 'active')->where('deleted_at', null)->limit(1)->first();

        if (is_null($clinic)) {
            return $this->sendError('Clinic with this id not available.', 'Clinic with this id not available', 404);
        }

        return $this->sendResponse(new ClinicDetailResource($clinic), 'Clinic Details fetched successfully.');
    }
    public function getClinicScheduleDates(Request $request, $id)
    {
        $clinic = Clinic::where('id', $id)->where('status', 'active')->where('deleted_at', null)->limit(1)->first();

        if (is_null($clinic)) {
            return $this->sendError('Clinic with this id not available.', 'Clinic with this id not available', 404);
        }
        $size = $request->size ?? 10;
        $current_date = Carbon::now();
        $dates = ScheduleDate::where('clinic_id', $clinic->id)
            ->whereDate('date', '>=', $current_date)
            ->paginate($size);

        return $this->sendResponse(ScheduleDateResource::collection($dates)->response()->getData(true), 'Clinic dates fetched successfully.');
    }
}
