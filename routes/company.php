<?php

use App\Http\Controllers\Auth\company\ForgotPasswordController;
use App\Http\Controllers\Company\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\EmployeeController;
use App\Http\Controllers\Auth\company\ResetPasswordController;

Route::prefix('company')->name('company.')->group(function () {
    Route::group(['middleware' => 'company.guest'], function () {
        Route::view('login', 'company.login')->name('login');
        
        Route::post('login', [CompanyController::class, 'login'])->name('auth');
        Route::get('register', [CompanyController::class, 'register'])->name('register');
        Route::post('register', [CompanyController::class, 'postRegisterRequest'])->name('postRegisterRequest');

        Route::get('password/reset', [CompanyController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [CompanyController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [CompanyController::class, 'showResetForm']);
        Route::post('password/reset', [CompanyController::class, 'reset'])->name('password.update');
    });
        Route::group(['middleware' => 'company.auth'], function () {
        Route::get('dashboard', [CompanyController::class, 'dashboard'])->name('home');
        Route::post('logout', [CompanyController::class, 'logout'])->name('logout');
        Route::get('profile', [CompanyController::class, 'getProfile'])->name('getProfile');
        Route::post('profile', [CompanyController::class, 'postUpdateProfile'])->name('postUpdateProfile');

        Route::get('employee/manage', [EmployeeController::class, 'getEmployeeManage'])->name('getEmployeeManage');
        Route::post('employee/add', [EmployeeController::class, 'postAddEmployee'])->name('postAddEmployee');
        Route::post('employee/import', [EmployeeController::class, 'postImportEmployee'])->name('postImportEmployee');
        Route::get('employee/delete/{employee_id}', [EmployeeController::class, 'getDeleteEmployee'])->name('getDeleteEmployee');
        Route::get('employee/edit/{employee_id}', [EmployeeController::class, 'getEditEmployee'])->name('getEditEmployee');
        Route::post('employee/edit/{employee_id}', [EmployeeController::class, 'postEditEmployee'])->name('postEditEmployee');
        Route::get('employee/send/password/{employee_id}', [EmployeeController::class, 'getSendPasswordOfEmployee'])->name('getSendPasswordOfEmployee');
        Route::post('ajax/getAjaxEmployeeDetail', [EmployeeController::class, 'getAjaxEmployeeDetail'])->name('getAjaxEmployeeDetail');

        Route::get('clinic/manage', [EmployeeController::class, 'getManageClinics'])->name('getManageClinics');
        Route::get('clinic/refercode/generate', [EmployeeController::class, 'getGenerateReferCode'])->name('getGenerateReferCode');
        Route::get('clinic/refercode/delete/{refer_code}', [EmployeeController::class, 'getDeleteReferCode'])->name('getDeleteReferCode');
        Route::post('clinic/send/refercode/{code}', [EmployeeController::class, 'sendReferCodetoClinic'])->name('sendReferCodetoClinic');
        Route::get('clinic/ajax/companyinfo', [EmployeeController::class, 'getCompanyFromReferCode'])->name('getCompanyFromReferCode');
        Route::post('/connect-clinic/add', [EmployeeController::class, 'addCompanyFromReferCode'])->name('addCompanyFromReferCode');


        Route::get('account/manage', [AccountController::class, 'getManageAccount'])->name('getManageAccount');
        Route::get('account/manage/{employee_id}', [AccountController::class, 'viewAppointmentDetails'])->name('viewAppointmentDetails');
        Route::get('account/appointment/details/{employee_id}/{id}', [AccountController::class, 'viewAppointmentAllDetails'])->name('viewAppointmentAllDetails');
    });
});
