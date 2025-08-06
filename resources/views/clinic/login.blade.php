@extends('site.template')
@section('content')
<div class="login-content-info" style="background:url({{asset('site/assets/img/clinicloginbg.jpeg')}}); background-size:cover">
    <div class="container">
       <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6" style="background: #fff; box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);">
             <div class="account-content" style="padding: 10px">
                <div class="login-shapes">
                   <div class="shape-img-left">
                      <img src="{{asset('site/assets/img/shape-01.png')}}" alt="">
                   </div>
                   <div class="shape-img-right">
                      <img src="{{asset('site/assets/img/shape-02.png')}}" alt="">
                   </div>
                </div>
                <div class="account-info">
                   <div class="login-back">
                      <a href="{{route('getHome')}}"><i class="fas fa-arrow-left-long"></i> Back</a>
                   </div>
                   <div class="login-title">
                      <h3>Clinic Login</h3>
                   </div>
                   <div class="row">
                     @if (session()->has('status'))
                     <div class="alert alert-success text-center">
                         {{ session('status') }}
                     </div>
                 @endif
                 @if (session()->has('fail'))
                 <div class="alert alert-danger text-center">
                     {{ session('fail') }}
                 </div>
             @endif
                   </div>
                   <form action="{{ route('clinic.login') }}" method="POST">
                        @csrf()
                      <div class="form-group">
                         <label>E-mail</label>
                         <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" placeholder="Email Address" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                      </div>
                      <div class="form-group">
                         <div class="form-group-flex">
                            <label>Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('clinic.password.request') }}" class="forgot-link">Forgot password?</a>
                            @endif
                         </div>
                         <div class="pass-group">
                            <input type="password" name="password" class="form-control pass-input @error('password') is-invalid @enderror" placeholder="Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                            <span class="feather-eye toggle-password"></span>
                         </div>
                      </div>
                      <div class="form-group form-check-box">
                         <div class="form-group-flex">
                            <label class="custom_check d-inline-flex"> Remember Me
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            </label>
                           
                         </div>
                      </div>
                      <div class="form-group">
                         <button class="btn btn-block" type="submit">Sign in</button>
                      </div>
                      <div class="login-or">
                         <span class="or-line"></span>
                         <span class="span-or">or</span>
                      </div>
                     
                      <div class="account-signup">
                         <p>Don't have an account ? <a href="{{route('clinic.getClinicRegister')}}">Register</a></p>
                      </div>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <div class="mouse-cursor cursor-outer"></div>
 <div class="mouse-cursor cursor-inner"></div>
@stop

