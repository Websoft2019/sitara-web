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
                      <h3>Clinic Password Reset</h3>
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
                   <form action="{{ route('clinic.password.update') }}" method="POST">
                    <input type="hidden" name="token" value="{{ $token }}">
                        @csrf()
                      <div class="form-group">
                         <label>E-mail Address</label>
                         <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" placeholder="Email Address" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                      </div>
                      <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"required>
                           @error('password')
                               <span class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                               </span>
                           @enderror
                     </div>
                     <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" id="password-confirm" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
                     </div>
                      
                      
                      <div class="form-group">
                         <button class="btn btn-block" type="submit">Reset Password</button>
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

