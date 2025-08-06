<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function getHome(){
        return view('site.home');
    }
    public function getCompanyLogin(){
        return view('company.auth.login');
    }
    public function getClinicLogin(){
        return view('clinic.auth.login');
    }
    public function getAbout(){
        return view('site.about');
    }
    public function getContact(){
        return view('site.contact');
    }
    public function getTerms(){
        return view('site.terms');
    }
    public function getPolicy(){
        return view('site.policy');
    }
    public function getWhySitara(){
        return view('site.whysitara');
    }
    public function getRefundPolicy(){
        return view('site.refundplicy');
    }
}
