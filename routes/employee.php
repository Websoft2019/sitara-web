<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\HomeController;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::prefix('employee')->name('user.')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/clinic-lists', [HomeController::class, 'getClinicList'])->name('getClinicList');
        Route::get('/book-appointment/{clinic}', [HomeController::class, 'getBookAppointment'])->name('getBookAppointment');
        Route::post('/book-appointment/{clinic}', [HomeController::class, 'postAppointment'])->name('postAppointment');
        Route::get('/my-reservations', [HomeController::class, 'getAppointmented'])->name('getAppointmented');
        Route::get('/appointment/detail/{id}', [HomeController::class, 'getViewAppointment'])->name('getViewAppointment');
        Route::get("/dependent", [HomeController::class, 'getDependent'])->name('getDependent');
        Route::post("/dependent", [HomeController::class, 'postDependent'])->name('postDependent');
    });
});
