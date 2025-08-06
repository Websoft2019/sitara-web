<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\SiteController::class, 'getHome'])->name('getHome');
Route::get('/about', [App\Http\Controllers\SiteController::class, 'getAbout'])->name('getAbout');
Route::get('/why-sitara', [App\Http\Controllers\SiteController::class, 'getWhySitara'])->name('getWhySitara');
Route::get('/contact', [App\Http\Controllers\SiteController::class, 'getContact'])->name('getContact');
Route::get('/terms', [App\Http\Controllers\SiteController::class, 'getTerms'])->name('getTerms');
Route::get('/privacy', [App\Http\Controllers\SiteController::class, 'getPolicy'])->name('getPolicy');
Route::get('/refund-policy-cancellation', [App\Http\Controllers\SiteController::class, 'getRefundPolicy'])->name('getRefundPolicy');

require __DIR__.'/admin.php';
require __DIR__.'/company.php';
require __DIR__.'/clinic.php';
require __DIR__.'/employee.php';


