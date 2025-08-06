@extends('company.template', ['activePage' => 'companyemployee'])

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-7 col-auto">
                        <h3 class="page-title">Employee</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('company.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Employee</li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <a href="#importemployee" data-bs-toggle="modal" class="btn btn-primary float-end mt-2">Import from
                            Excel</a>
                        <a href="#companyemployee" data-bs-toggle="modal" class="btn btn-success float-end mt-2"
                            style="margin-right: 10px">Add</a>
                    </div>

                    @if (session('pdfUrl'))
                        <div class="bg-danger text-white p-2">You have duplicate email here! <a href="{{ asset('duplicate_emails.pdf') }}">click here</a></div>
                    @endif

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="text-align: center">Employee Information</th>
                                            <th>Claim Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($company->getEmployeesFromCompany as $item)
                                            <tr>
                                                <td>{{ $item->employee_id }}</td>
                                                <td>
                                                    <div class="profile-header"
                                                        style="background-color:transparent; border:none; padding:0">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto profile-image">
                                                                @if ($item->image)
                                                                    <img class="rounded-circle" alt="User Image"
                                                                        src="{{ asset('site/uploads/company/employee/' . $item->image) }}"
                                                                        width="41">
                                                                @else
                                                                    <img class="rounded-circle" alt="User Image"
                                                                        src="{{ asset('site/assets/img/logo.png') }}">
                                                                @endif

                                                            </div>
                                                            <div class="col ml-md-n2 profile-user-info">
                                                                <h6 class="user-name mb-0">{{ $item->first_name }}
                                                                    {{ $item->middle_name }} {{ $item->last_name }}</h6>
                                                                <h6 class="text-muted">{{ $item->post }},
                                                                    {{ $item->gender }}</h6>
                                                                <div class="user-Location"><i class="fa fa-phone"></i>
                                                                    {{ $item->phone_number }} | IC#{{ $item->ic_number }}
                                                                </div>
                                                                <div class="about-text"></div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </td>
                                                <td>MYR {{ $item->per_visit_claim }} <small style="display: block">/per
                                                        visit</small></td>

                                                <td>
                                                    @if ($item->status == 'active')
                                                        <b class="text-success">Active</b>
                                                    @else
                                                        <b class="text-danger">Hidden</b>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="actions">
                                                        <a class="btn btn-sm bg-success-light employee_details"
                                                            id="{{ $item->employee_id }}">
                                                            <i class="fe fe-pencil"></i> Detail
                                                        </a>
                                                        <a class="btn btn-sm bg-success-light"
                                                            href="{{ route('company.getEditEmployee', $item->employee_id) }}">
                                                            <i class="fe fe-pencil"></i> Edit
                                                        </a>
                                                        <a class="btn btn-sm bg-danger-light"
                                                            href="{{ route('company.getDeleteEmployee', $item->employee_id) }}"
                                                            onclick="if(!confirm(`Are you sure to delete employee {{ $item->name }}!`)) { event.preventDefault(); }">Delete</a>

                                                        <a class="btn btn-sm bg-warning-light"
                                                            href="{{ route('company.getSendPasswordOfEmployee', $item->employee_id) }}"
                                                            onclick="if(!confirm(`Are you sure to update password of {{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}!`)) { event.preventDefault(); }">Send
                                                            Password</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="model_employee_details" tabindex="-1" aria-labelledby="companyemployeeLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="companyemployeeLabel">Employee Detail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="">
                            <div class="box">

                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4 col-xxl-3">
                                            <div class="box-body-image">
                                                <img id="model_employee_image" src="https://sitara.my/site/uploads/company/employee/e19e7b98b2d67d8977483920d9b9a33f8c927b19.jpg"
                                                    alt="" class="img-fluid ">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <b>Name: </b><span id="model_employee_details_name"></span><br>
                                            <b>Employee Id: </b> <span id="model_employee_id"></span> <br>
                                            <b>Address: </b> <span id="model_employee_address"></span><br>
                                            <b>Email: </b><span id="model_employee_email"></span><br>
                                            <b>Contact Number: </b><span id="model_employee_Contactnumber"></span> <br>
                                            <b>Per Visit Claim: </b>RM <span id="model_employee_Visitclaim"></span> <br>
                                            <b>Company: </b><span id="model_employee_Company"></span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <br />
                                            <hr>
                                            <h6>List of Dependents</h6>
                                            <div id="model_dependents_list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="companyemployee" tabindex="-1" aria-labelledby="companyemployeeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="companyemployeeLabel">Add Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <form method="POST" action="{{ route('company.postAddEmployee') }}"
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
                                                <small
                                                    style="font-weight: bold">{{ $errors->first('first_name') }}</small>
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
                                                <small
                                                    style="font-weight: bold">{{ $errors->first('middle_name') }}</small>
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
                                                <small
                                                    style="font-weight: bold">{{ $errors->first('employee_id') }}</small>
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
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}">

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
                                                <small
                                                    style="font-weight: bold">{{ $errors->first('phone_number') }}</small>
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
                                        <input type="date" class="form-control" id="date_of_birth"
                                            name="date_of_birth" value="{{ old('date_of_birth') }}" required>

                                        @if ($errors->has('date_of_birth'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small
                                                    style="font-weight: bold">{{ $errors->first('date_of_birth') }}</small>
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
                                        <label for="ic_number">IC Number(*)</label>
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
                                                <small
                                                    style="font-weight: bold">{{ $errors->first('description') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-success" value="Add">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="importemployee" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('company.postImportEmployee') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label>Excel File</label>
                                    <input type="file" class="form-control" name="excelfile" required>
                                    <small><a href="{{ asset('site/assets/excel/employeeimportformat.xlsx') }}"
                                            target="_blank">Excel format</a></small>

                                    @if ($errors->has('excelfile'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('excelfile') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary w-100" value="Import">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.employee_details').click(function() {

            let emp_id = this.id;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('company.getAjaxEmployeeDetail') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    emp_id: emp_id,
                },
                success: function(response) {
                    // console.log(response);
                    document.getElementById("model_employee_image").src = response.employeeImage,
                    document.getElementById("model_employee_details_name").innerHTML = response.employeeName,
                    document.getElementById("model_employee_id").innerHTML = response.employeeID,
                    document.getElementById("model_employee_address").innerHTML = response.employeeAddress,
                    document.getElementById("model_employee_email").innerHTML = response.employeeEmail,
                    document.getElementById("model_employee_Contactnumber").innerHTML = response.employeeContactnumber,
                    document.getElementById("model_employee_Visitclaim").innerHTML = response.employeeVisitclaim,
                    document.getElementById("model_employee_Company").innerHTML = response.employeeCompany,
                    document.getElementById("model_dependents_list").innerHTML = response.dependentLists
                    $('#model_employee_details').modal('show');
                },
            });
        });



        /*------------------------------------------
        --------------------------------------------
        Toastr Success Code
        --------------------------------------------
        --------------------------------------------*/
        function displayMessage(message) {
            toastr.success(message, 'Congratulations!');
        }

        function errorMessage(message) {
            toastr.error(message, 'Sorry!');
        }
    </script>

    <script>
        $(document).ready(function() {
            // Check if there are any validation errors
            @if ($errors->any())
                $('#companyemployee').modal('show');
            @endif
            // Optionally, you can use localStorage to persist modal state if needed
            $('#companyemployee').on('shown.bs.modal', function() {
                localStorage.setItem('modalOpen', 'true');
            });
            $('#companyemployee').on('hidden.bs.modal', function() {
                localStorage.setItem('modalOpen', 'false');
            });
            if (localStorage.getItem('modalOpen') === 'true') {
                $('#companyemployee').modal('show');
            }
        });
    </script>
@stop
