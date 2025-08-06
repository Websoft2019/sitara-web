@extends('layouts.admin', ['activePage' => 'admincompanymanage'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $company->name }} - Employee Manage</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="#">Dashboard</a></li> -->
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">{{ $company->name }}</li>
                        <li class="breadcrumb-item active">Employee</li>
                        <li class="breadcrumb-item active">Manage</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <div class="bd-example bd-example-padded-bottom">
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                    data-target="#admincompanyemployee">
                                    Add Employee
                                </button>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <table id="admincompanyemployeetable" class="table table-stripped table-bordered"
                                style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Contact</th>
                                        <th>Details</th>
                                        <th>Status</th>
                                        <th>Dependent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($company->getEmployeesFromCompany as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if ($item->image)
                                                    <img src="{{ asset('site/uploads/company/employee/' . $item->image) }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @else
                                                    <img src="{{ asset('site/assets/img/logo.png') }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @endif
                                            </td>
                                            <td>
                                                <b>Name: </b>{{ $item->first_name }} {{ $item->middle_name }}
                                                {{ $item->last_name }} <br>
                                                <b>Email: </b>{{ $item->email }} <br>
                                                <b>Number: </b>{{ $item->phone_number }} <br>
                                                <b>IC Number: </b>{{ $item->ic_number }} <br>
                                                <b>Per Visit Claim: </b>MYR {{ $item->per_visit_claim }}<br>
                                            </td>
                                            <td>
                                                <b>Post: </b>{{ $item->post }} <br>
                                                <b>DOB: </b>{{ $item->date_of_birth }} <br>
                                                <b>Race: </b>{{ $item->race }} <br>
                                                <b>Gender: </b><span
                                                    style="text-transform: capitalize;">{{ $item->gender }}</span> <br>
                                                <b>Address: </b>{{ $item->address }}<br>
                                            </td>
                                            <td>
                                                @if ($item->status == 'active')
                                                    <b class="text-success">Active</b>
                                                @else
                                                    <b class="text-danger">Hidden</b>
                                                @endif
                                            </td>
                                            <td>
                                                <div><a class="btn btn-primary" href="{{ route('admin.getDependent', ['slug' => $slug, 'id' => $item->id, 'dependentid' => $item->id]) }}">Dependent</a></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {!! $companys->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content ends here -->

    {{-- <!-- add category model -->
    <div id="admincompanyemployee" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="gridModalLabel">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.postAddCompanyEmployee', $company->slug) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name">First Name (*)</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ old('first_name') }}" required>
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('first_name') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                                        value="{{ old('middle_name') }}">
                                    @if ($errors->has('middle_name'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('middle_name') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name">Last Name (*)</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name') }}" required>
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('last_name') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employee_id">Employee ID (*)</label>
                                    <input type="text" class="form-control" id="employee_id" name="employee_id"
                                        value="{{ old('employee_id') }}" required>
                                    @if ($errors->has('employee_id'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('employee_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        value="{{ old('image') }}">
                                    @if ($errors->has('image'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('image') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email (*)</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('email') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number (*)</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        value="{{ old('phone_number') }}" required>

                                    @if ($errors->has('phone_number'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('phone_number') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="post">Post (*)</label>
                                    <input type="text" class="form-control" id="post" name="post"
                                        value="{{ old('post') }}" required>

                                    @if ($errors->has('post'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('post') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth (*)</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth') }}" required>

                                    @if ($errors->has('date_of_birth'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('date_of_birth') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">Gender (*)</label>
                                    <select id="gender" class="form-control" name="gender" required>
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('gender') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="race">Race (*)</label>
                                    <input type="text" class="form-control" id="race" name="race"
                                        value="{{ old('race') }}" required>

                                    @if ($errors->has('race'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('race') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ic_number">IC Number (*)</label>
                                    <input type="text" class="form-control" id="ic_number" name="ic_number"
                                        value="{{ old('ic_number') }}" required>

                                    @if ($errors->has('ic_number'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('ic_number') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address (*)</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address') }}" required>

                                    @if ($errors->has('address'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('address') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="per_visit_claim">Per Visit Claim (*)</label>
                                    <input type="number" class="form-control" id="per_visit_claim"
                                        name="per_visit_claim" value="{{ old('per_visit_claim') }}" required>

                                    @if ($errors->has('per_visit_claim'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small
                                                style="font-weight: bold">{{ $errors->first('per_visit_claim') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status (*)</label>
                                    <select id="status" class="form-control" name="status" required>
                                        <option value="active" selected>Active</option>
                                        <option value="hidden">Hidden</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('status') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea type="text" class="form-control" id="description" rows="8" name="description" value="">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('description') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- add category model ends --> --}}
@endsection
@section('js')
    <script>
        $(function() {
            $("#admincompanyemployeetable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
