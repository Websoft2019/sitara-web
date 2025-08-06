<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DependentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('update/password', [AuthController::class, 'updatePassword']);
        Route::post('change/password', [AuthController::class, 'changePassword']);

        Route::prefix('profile')->group(function () {
            Route::get('me', [ProfileController::class, 'getProfileOfMe']);
            Route::post('image/upload', [ProfileController::class, 'postImageUpload']);
        });
    });
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::get('home', [HomeController::class, 'getHomeContents']);
    Route::get('clinics', [HomeController::class, 'getClinics']);
    Route::get('clinic/details/{id}', [HomeController::class, 'getClinicDetails']);
    Route::get('clinic/dates/{id}', [HomeController::class, 'getClinicScheduleDates']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('appointment', [AppointmentController::class, 'postAppointment']);
    Route::get('appointment/cancel/{id}', [AppointmentController::class, 'getAppointmentCancel']);
    Route::get('allfromappointment', [AppointmentController::class, 'getAllDataFromAppointment']);

    Route::get('appointments/upcoming', [AppointmentController::class, 'getAllUpcomingAppointments']);
    Route::get('appointments/completed', [AppointmentController::class, 'getAllCompletedAppointments']);
    Route::get('appointments/cancelled', [AppointmentController::class, 'getAllCancelledAppointments']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get("mydependent", [DependentController::class, 'getMyDependent']);
});