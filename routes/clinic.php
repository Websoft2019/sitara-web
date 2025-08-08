<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clinic\ClinicController;
use App\Http\Controllers\Clinic\CompanyController;
use App\Http\Controllers\Clinic\ScheduleController;

Route::prefix('clinic')->name('clinic.')->group(function () {
    Route::group(['middleware' => 'clinic.guest'], function () {
        Route::view('login', 'clinic.login')->name('login');
        Route::post('login', [ClinicController::class, 'login'])->name('auth');
        Route::get('clinic-register', [ClinicController::class, 'getClinicRegister'])->name('getClinicRegister');
        Route::post('clinic-request-register', [ClinicController::class, 'postClinicRequestRegister'])->name('postClinicRequestRegister');
        // Route::post('clinic-register', [ClinicController::class, 'postClinicRegister'])->name('postClinicRegister');
        Route::get('password/reset', [ClinicController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ClinicController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ClinicController::class, 'showResetForm']);
        Route::post('password/reset', [ClinicController::class, 'reset'])->name('password.update');
    });
    Route::group(['middleware' => 'clinic.auth'], function () {
        Route::post('logout', [ClinicController::class, 'logout'])->name('logout');
        Route::get('profile', [ClinicController::class, 'getProfile'])->name('getProfile');
        Route::post('profile', [ClinicController::class, 'postUpdateProfile'])->name('postUpdateProfile');
        // this route update the clinic profile
        Route::post('update/clinic/profile', [ClinicController::class, 'postUpdateClinicProfile'])->name('postUpdateClinicProfile');

        Route::get('/dashboard', [ClinicController::class, 'home'])->name('home');
        Route::get('/appointments', [ClinicController::class, 'getAppointments'])->name('getAppointments');
        Route::get('/company', [CompanyController::class, 'getManageCompany'])->name('getManageCompany');

        Route::get('schedule/manage', [ScheduleController::class, 'getManageSchedule'])->name('getManageSchedule');
        Route::post('schedule/post-set-time-for-weekend', [ScheduleController::class, 'postSetTimeForWeekend'])->name('postSetTimeForWeekend');
        Route::post('schedule/add', [ScheduleController::class, 'postAddScheduleDate'])->name('postAddScheduleDate');
        Route::post('schedule/update', [ScheduleController::class, 'postUpdateScheduleDate'])->name('postUpdateScheduleDate');

        Route::get('schedule/manage', [ScheduleController::class, 'getManageSchedule'])->name('getManageSchedule');
        // Route::post('schedule/add', [ScheduleController::class, 'postAddScheduleDate'])->name('postAddScheduleDate');
        Route::post('schedule/time/{date}', [ScheduleController::class, 'postAddTime'])->name('postAddTime');
        Route::get('schedule/time/delete/{time}', [ScheduleController::class, 'getDeleteScheduleTime'])->name('getDeleteScheduleTime');

        Route::get('doctor/manage', [ClinicController::class, 'getManageDoctors'])->name('getManageDoctors');
        Route::post('doctor/manage', [ClinicController::class, 'postAddDoctor'])->name('postAddDoctor');
        Route::post('doctor/edit/{id}', [ClinicController::class, 'postEditDoctor'])->name('postEditDoctor');
        Route::get('doctor/delete/{id}', [ClinicController::class, 'getDeleteClinicDoctor'])->name('getDeleteClinicDoctor');
        Route::post('doctor/assign', [ClinicController::class, 'postAssignDoctor'])->name('postAssignDoctor');
        Route::get('patient-list', [ClinicController::class, 'getPatients'])->name('getPatients');
        Route::post('model/appointmentdetail', [ClinicController::class, 'AjaxAppointmentDetail'])->name('AjaxAppointmentDetail');

        Route::get('checkup/{appointment}', [ClinicController::class, 'getCheckUpPanel'])->name('getCheckUpPanel');
        Route::post('ajax/employeedetail', [ClinicController::class, 'getAjaxEmployeeDetail']);
        Route::post('appointment/add', [ClinicController::class, 'postAddAppointmentByClinic'])->name('postAddAppointmentByClinic');
        Route::get('appointment/cancel/{appointment}', [ClinicController::class, 'getCancelPatientAppointment'])->name('getCancelPatientAppointment');

        Route::post('report/prescrition/add/{appointment}', [ClinicController::class, 'postAddPrescriptionReport'])->name('postAddPrescriptionReport');
        Route::post('report/others/add/{appointment}', [ClinicController::class, 'postAddReports'])->name('postAddReports');
        Route::post('report/others/update/{report}', [ClinicController::class, 'postUpdateReports'])->name('postUpdateReports');
        Route::post('accounting/update/{account}', [ClinicController::class, 'postUpdateAccounting'])->name('postUpdateAccounting');
        Route::post('accounting/add/{appointment}', [ClinicController::class, 'postAddAccounting'])->name('postAddAccounting');

        Route::get('appointment/payment/complete/{appointment}', [ClinicController::class, 'getPaymentComplete'])->name('getPaymentComplete');

        Route::get('/company/remove/{id}', [CompanyController::class, 'getRemoveCompany'])->name('getRemoveCompany');
        Route::get('/company/get', [CompanyController::class, 'getCompanyFromReferCode'])->name('getCompanyFromReferCode');
        Route::post('/company/add', [CompanyController::class, 'addCompanyFromReferCode'])->name('addCompanyFromReferCode');

        Route::get('/account/manage', [CompanyController::class, 'getManageAccounts'])->name('getManageAccounts');
        // Route::get('/account/manage', [CompanyController::class, 'getManageAccounts'])->name('getManageAccounts');

        Route::get('/client-sendcode-to-company/{company}', [CompanyController::class, 'getClinicSendInvokeCodeToCompany'])->name('getClinicSendInvokeCodeToCompany');
    });
});
