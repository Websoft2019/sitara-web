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
                      <h3>Clinic Register</h3>
                   </div>
                   <div class="row">
                    @if (session('fail'))
                        <div class="alert alert-success" role="alert">
                            {{ session('fail') }}
                        </div>
                    @endif
                   </div>
                   <form action="{{ route('clinic.postClinicRequestRegister') }}" method="POST" enctype="multipart/form-data">
                        @csrf()
                        <div class="form-group">
                            <label>Name of Clinic</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" placeholder="Clinic Name" required>
                               @error('name')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                         </div>
                         <div class="form-group">
                            <label>Full Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address')}}" placeholder="Clinic Address" required>
                               @error('address')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                         </div>
                         <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{old('city')}}" placeholder="City" required>
                               @error('city')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                         </div>
                         <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{old('state')}}" placeholder="State" required>
                               @error('state')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                         </div>
                         <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" class="form-control @error('postalcode') is-invalid @enderror" name="postalcode" value="{{old('postalcode')}}" placeholder="Postal Code" required>
                               @error('postalcode')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                         </div>
                         
                         <div class="form-group">
                            <label>Dr. Incharge</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" name="contactperson" value="{{old('contactperson')}}" placeholder="Contact Person" required>
                               @error('contactperson')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                         </div>
                         <div class="form-group">
                           <label>MMC Number</label>
                           <input type="text" class="form-control @error('mmcnumber') is-invalid @enderror" name="mmcnumber" value="{{ old('mmcnuner') }}" placeholder="MMC Number" required>
                              @error('mmcnumber')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                        </div>
                        <div class="form-group">
                           <label>B Form</label>
                           <input type="file" class="form-control @error('bform') is-invalid @enderror" name="bform" value="{{old('bform')}}" required>
                              @error('bform')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                        </div>
                         <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" name="contactnumber" value="{{old('contactnumber')}}" placeholder="Contact  Number" required>
                               @error('contactnumber')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                         </div>
                         <div class="form-group">
                            <label>Opening Hours </label>
                            <input type="text" class="form-control @error('openinghour') is-invalid @enderror" name="openinghour" value="{{old('openinghour')}}" placeholder="Opeining Hour" required>
                               @error('openinghour')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                         </div>
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
                         <button class="btn btn-block" type="submit">Register</button>
                      </div>
                      <div class="login-or">
                         <span class="or-line"></span>
                         <span class="span-or">or</span>
                      </div>
                     
                      <div class="account-signup">
                         <p>already have an account ? <a href="{{route('clinic.login')}}">login</a></p>
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

