
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\CompanyController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::view('login', 'admin.login')->name('login');
        Route::post('login', [AdminController::class, 'login'])->name('auth');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::view('dashboard', 'admin.home')->name('home');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('profile', [AdminController::class, 'getProfile'])->name('getProfile');
        Route::post('profile', [AdminController::class, 'postUpdateProfile'])->name('postUpdateProfile');

        Route::post('company-account-details', [CompanyController::class, 'getCompanyAccountDetailAjax'])->name('company-account-details-ajax');
        Route::get('company/manage', [CompanyController::class, 'getManageCompany'])->name('getManageCompany');
        Route::get('company/delete/{slug}', [CompanyController::class, 'getDeleteCompany'])->name('getDeleteCompany');
        Route::get('company/edit/{slug}', [CompanyController::class, 'getEditCompany'])->name('getEditCompany');
        Route::post('company/edit/{slug}', [CompanyController::class, 'postEditCompany'])->name('postEditCompany');
        Route::get('company/send/password/{slug}', [CompanyController::class, 'getSendPasswordForCompany'])->name('getSendPasswordForCompany');
        Route::post('company/add', [CompanyController::class, 'postAddCompany'])->name('postAddCompany');
        Route::get('company/{slug}/employee/manage', [CompanyController::class, 'getManageCompanyEmployee'])->name('getManageCompanyEmployee');
        Route::post('company/{slug}/employee/add', [CompanyController::class, 'postAddCompanyEmployee'])->name('postAddCompanyEmployee');
        // Add Dependent
        Route::get("company/{slug}/employee/{id}/dependent", [CompanyController::class, 'getDependent'])->name('getDependent');
        Route::post("company/{slug}/employee/{id}/dependent", [CompanyController::class, 'postDependent'])->name('postDependent');
        Route::delete("company/{slug}/employee/{id}/dependent/remove/{dependentid}", [CompanyController::class, 'deleteDependent'])->name('deleteDependent');
        Route::patch("company/{slug}/employee/{id}/dependent/change-status/{dependentid}", [CompanyController::class, 'statusChangeDependent'])->name('statusChangeDependent');

        Route::get('clinic/manage', [ClinicController::class, 'getManageClinic'])->name('getManageClinic');
        Route::get('clinic/delete/{slug}', [ClinicController::class, 'getDeleteClinic'])->name('getDeleteClinic');
        Route::get('clinic/edit/{slug}', [ClinicController::class, 'getEditClinic'])->name('getEditClinic');
        Route::post('clinic/edit/{slug}', [ClinicController::class, 'postEditClinic'])->name('postEditClinic');
        Route::post('clinic/add', [ClinicController::class, 'postAddClinic'])->name('postAddClinic');
        Route::get('clinic/{slug}/user/manage', [ClinicController::class, 'getManageClinicUser'])->name('getManageClinicUser');
        Route::post('clinic/{slug}/user/add', [ClinicController::class, 'postAddClinicUser'])->name('postAddClinicUser');
        Route::post('clinic/user/edit/{id}', [ClinicController::class, 'postEditClinicUser'])->name('postEditClinicUser');
        Route::get('clinic/user/delete/{id}', [ClinicController::class, 'getDeleteClinicUser'])->name('getDeleteClinicUser');
        Route::get('clinic/user/send/password/{id}', [ClinicController::class, 'getSendPasswordForClinicUser'])->name('getSendPasswordForClinicUser');

        Route::get('/company/account/manage', [CompanyController::class, 'getManageCompanyAccount'])->name('getManageCompanyAccount');
        Route::get('/company/account/details/{slug}', [CompanyController::class, 'getCompanyAccountDetails'])->name('getCompanyAccountDetails');
        Route::get('/clinic/account/manage', [ClinicController::class, 'getManageClinicAccount'])->name('getManageClinicAccount');
        Route::get('/clinic/account/details/{slug}', [CompanyController::class, 'getClinicAccountDetails'])->name('getClinicAccountDetails');

        Route::get('/registration-request', [AdminController::class, 'getRegistrationRequestList'])->name('getRegistrationRequestList');
        Route::get('/registration-request/approve/{registration}', [AdminController::class, 'getRegistrationRequestApprove'])->name('getRegistrationRequestApprove');

        Route::get('/company/payable-bill-of-month/pdf/{company}/{clinic}/{date}', [CompanyController::class, 'getpayableBillofMonthPDF'])->name('getpayableBillofMonthPDF');
        Route::get('/company/get-all-payable-bill-of-month/pdf/{company}/{clinic}/{date}', [CompanyController::class, 'getALLpayableBillofMonthPDF'])->name('getALLpayableBillofMonthPDF');
    });
});

