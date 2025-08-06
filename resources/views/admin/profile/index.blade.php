@extends('layouts.admin', ['activePage' => 'adminhome'])

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Profile</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item active"><a href="#">Dashboard</a></li> -->
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          

          <div class="card card-primary card-outline">
            <div class="card-body">
              <h5 class="card-title">Update Your Profile</h5>

              <p class="card-text">
                <form method="POST" action="{{ route('admin.postUpdateProfile') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name (*)</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{$admin->name}}" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger" style="font-style: italic;">
                                        <small style="font-weight: bold">{{ $errors->first('name') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Email</label>
                                <input type="email" class="form-control" id="address" name="email"
                                    value="{{ $admin->email }}" disabled>

                                @if ($errors->has('email'))
                                    <span class="text-danger" style="font-style: italic;">
                                        <small style="font-weight: bold">{{ $errors->first('email') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Role</label>
                                <input type="text" class="form-control" id="" name=""
                                    value="Administrator" disabled>

                                @if ($errors->has('role'))
                                    <span class="text-danger" style="font-style: italic;">
                                        <small style="font-weight: bold">{{ $errors->first('role') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Password (If your want to change make empty)</label>
                                <input type="password" class="form-control" id="password" name="password">

                                @if ($errors->has('password'))
                                    <span class="text-danger" style="font-style: italic;">
                                        <small style="font-weight: bold">{{ $errors->first('password') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>

                        
                        
                        
                       
                        
                       
                        
                       
                    </div>

                    
                </form>
              </p>
              
            </div>
          </div><!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
@endsection
