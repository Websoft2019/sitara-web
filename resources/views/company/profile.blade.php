@extends('company.template', ['activePage' => 'companyhome'])
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3 class="page-title">Company Panel</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
                $employee_count = \App\Models\User::where('company_id', Auth::user()->id)->where('deleted_at', null)->count();
                $affilated_clinics_count = \App\Models\CompanyClinic::where('company_id', Auth::user()->id)->where('deleted_at', null)->count();
            ?>
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Update Profile</h3>
                                </div>
                            </div>
                            <div class="dash-widget-header">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="POST" action="{{ route('company.postUpdateProfile') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Name (*)</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                            value="{{ Auth()->user()->name }}" required>
                                                        @if ($errors->has('name'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('name') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="logo">Logo</label>
                                                        <input type="file" class="form-control" id="logo" name="logo"
                                                            value="{{ old('logo') }}">
                                                        @if ($errors->has('logo'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('logo') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="address">Address (*)</label>
                                                        <input type="numeric" class="form-control" id="address" name="address"
                                                            value="{{ Auth()->user()->address }}" required>
                    
                                                        @if ($errors->has('address'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('address') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="longitude">Longitude</label>
                                                        <input type="numeric" class="form-control" id="longitude" name="longitude"
                                                            value="{{ Auth()->user()->longitude }}">
                    
                                                        @if ($errors->has('longitude'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('longitude') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="latitude">Latitude</label>
                                                        <input type="numeric" class="form-control" id="latitude" name="latitude"
                                                            value="{{ Auth()->user()->latitude }}">
                    
                                                        @if ($errors->has('latitude'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('latitude') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="registration_number">Registration Number (*)</label>
                                                        <input type="text" class="form-control" id="registration_number"
                                                            name="registration_number" value="{{ Auth()->user()->registration_number }}" disabled>
                    
                                                        @if ($errors->has('registration_number'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small
                                                                    style="font-weight: bold">{{ $errors->first('registration_number') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="email">Email (*)</label>
                                                        <input type="email" class="form-control" id="email" name="email"
                                                            value="{{ Auth()->user()->email }}" disabled>
                    
                                                        @if ($errors->has('email'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('email') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="commission">Commission (*)</label>
                                                        <input type="number" class="form-control" id="commission" name="commission"
                                                            value="{{ Auth()->user()->commission }}" disabled>
                    
                                                        @if ($errors->has('commission'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('commission') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div> --}}
                                               
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label for="number">Contact Number (*)</label>
                                                        <input type="text" class="form-control" id="number" name="number"
                                                            value="{{ Auth()->user()->number }}" required>
                    
                                                        @if ($errors->has('number'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('number') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="contact_person">Contact Person (*)</label>
                                                        <input type="text" class="form-control" id="contact_person" name="contact_person"
                                                            value="{{ Auth()->user()->contact_person }}" required>
                    
                                                        @if ($errors->has('contact_person'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('contact_person') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="contact_person_number">Contact Person Number (*)</label>
                                                        <input type="text" class="form-control" id="contact_person_number"
                                                            name="contact_person_number" value="{{ Auth()->user()->contact_person_number }}" required>
                    
                                                        @if ($errors->has('contact_person_number'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small
                                                                    style="font-weight: bold">{{ $errors->first('contact_person_number') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea type="text" class="form-control" id="description" rows="8" name="description">{{ Auth()->user()->description }}</textarea>
                                                        @if ($errors->has('description'))
                                                            <span class="text-danger" style="font-style: italic;">
                                                                <small style="font-weight: bold">{{ $errors->first('description') }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contact_person_number">New Password <small>(No Change password? Make Empty)</small></label>
                                                            <input type="password" class="form-control" id="password"
                                                                name="password">
                        
                                                            @if ($errors->has('password'))
                                                                <span class="text-danger" style="font-style: italic;">
                                                                    <small
                                                                        style="font-weight: bold">{{ $errors->first('password') }}</small>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contact_person_number">Confirm Password </small></label>
                                                            <input type="password" class="form-control" id="password_confirmation"
                                                                name="password_confirmation">
                        
                                                            @if ($errors->has('password_confirmation'))
                                                                <span class="text-danger" style="font-style: italic;">
                                                                    <small
                                                                        style="font-weight: bold">{{ $errors->first('password_confirmation') }}</small>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-success" value="Update">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
@stop
