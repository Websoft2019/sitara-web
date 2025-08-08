@extends('company.template', ['activePage' => 'companyclinics'])

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-7 col-auto">
                        <h3 class="page-title">Manage Clinic</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('company.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Clinic</li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <a href="{{ route('company.getGenerateReferCode') }}" class="btn btn-success float-end mt-2"
                            style="margin-right: 10px">Generate New Refer Code For Clinic</a>
                        <a href="#" class="btn btn-danger float-end mt-2" data-bs-toggle="modal"
                            data-bs-target="#add_appointment_modal" style="margin-right: 10px">Invoke Ref Code</a>
                    </div>
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
                                            <th>Id</th>
                                            <th>Refer Code</th>
                                            <th>Clinic</th>
                                            <th>Status</th>
                                            <th>Requested To</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($company->getCompanyClinicFromCompany as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->refer_code }}</td>
                                                <td>
                                                    @if ($item->clinic_id != null)
                                                        <b
                                                            class="text-success">{{ $item->getClinicFromCompanyClinic->name }}</b>
                                                    @else
                                                        <b class="text-danger">No Clinic Assign</b>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 'hidden' && $item->clinic_id == null && $item->request_clinic_id == null)
                                                        <b class="text-secondary">---</b>
                                                    @elseif ($item->status == 'hidden' && $item->clinic_id == null)
                                                        <b class="text-warning">Pending</b>
                                                    @else
                                                        <b class="text-success">Active</b>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $req_clinic = \App\Models\Clinic::find(
                                                            $item->request_clinic_id,
                                                        );
                                                    @endphp
                                                    {{ optional($req_clinic)->name }}
                                                </td>
                                                <td>
                                                    @if ($item->clinic_id != null)
                                                        {{-- <a href="" class="btn btn-sm btn-outline-primary">Detail </a> --}}
                                                        &nbsp;
                                                    @else
                                                        <a data-bs-toggle="modal" href="#sendEmail-{{ $item->refer_code }}"
                                                            class="btn btn-sm btn-outline-primary">Send Refer
                                                            Code to Clinic Email </a> &nbsp;
                                                    @endif

                                                    {{-- <a href="" class="btn btn-sm btn-outline-success">Edit</a> &nbsp; --}}
                                                    {{-- <a href="{{ route('company.getDeleteReferCode', $item->refer_code) }}"
                                                        class="btn btn-sm btn-outline-danger">Delete</a> --}}
                                                    {{-- <a href="{{ route('admin.', $item->id) }}">Delete</a> --}}
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

    <!-- edit category modal -->
    @foreach ($company->getCompanyClinicFromCompany as $refer_code)
        <div id="sendEmail-{{ $refer_code->refer_code }}" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="gridModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">#{{ $refer_code->refer_code }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="" method="POST"
                            action="{{ route('company.sendReferCodetoClinic', $refer_code->refer_code) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row form-row">
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        @php $listclinics = App\Models\Clinic::where('deleted_at', Null)->get(); @endphp
                                        <label>Clinic</label>
                                        <select class="form-control" name="company" required>
                                            @foreach ($listclinics as $listclinic)
                                                <option value="{{ $listclinic->id }}">{{ $listclinic->name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('company'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('company') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                {{-- <div class="" id="loadingBar">@include('layouts.loading')</div> --}}
                                <div><input type="submit" id="formSub" class="btn btn-primary"
                                        value="Send Refer Code to Clinic Mail">
                                </div>
                            </div>
                            {{-- <script>
                                document.getElementById('formSub').addEventListener('click', function() {
                                    console.log("you click here");
                                    document.getElementById('loadingBar').classList.add('d-none');
                                });
                            </script> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- edit category model ends -->
    <div class="modal fade custom-modal" id="add_appointment_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Clinic</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('company.addCompanyFromReferCode') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label">Ref Code</label>
                                            <input type="text" name="refer_code" id="referCode"
                                                class="form-control bank_name" placeholder="Ref code provide by Clinic">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <button type="button" class="form-control btn btn-primary" id="submitBtn"
                                                value="" style="color: #fff">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row" id="showRow" style="display: none;">
                            <div class="col-md-12">
                                <div class="card widget-profile pat-widget-profile">
                                    <div class="card-body">
                                        <div class="pro-widget-content">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="profile-info-widget" style="text-align:left !important">
                                                        <h2 class="table-avatar">
                                                            <a href="" class="avatar avatar-sm me-2">
                                                                <img class="avatar-img rounded-circle"
                                                                    src="{{ asset('site/assets/img/patients/patient.jpg') }}"
                                                                    alt="User Image" id="companyImage">
                                                            </a>
                                                            <span style="font-size: 22px" id="companyName">Company
                                                                Name</span>
                                                            <span style="font-size: 14px; display:block;"
                                                                id="companyAddress">
                                                                &nbsp; &nbsp; &nbsp;
                                                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Company
                                                                address</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="submit" class="btn btn-danger" value="Add Clinic">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="patient-info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li>Company Phone :<span id="companyNumber"></span></li>
                                                        <li>Company Email : <span id="companyEmail"></span></li>

                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li>Contact Person :<span id="companyContactPerson"> </span></li>
                                                        <li>Contact Number : <span id="companyContactPersonNumber"> </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let submitBtn = document.getElementById('submitBtn');

            $('#submitBtn').click(function() {
                let referCode = $('#referCode').val();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('company.getCompanyFromReferCode') }}",
                    data: {
                        refer_code: referCode,
                    },
                    success: function(data) {
                        if (data.success === true) {
                            $('#showRow').css('display', 'block');
                            $('#companyName').text(data.name);
                            if (data.logo) {
                                $('#companyImage').attr('src',
                                    '{{ asset('site/uploads/company') }}/' + data.logo);
                            } else {
                                $('#companyImage').attr('src',
                                    "{{ asset('site/assets/img/logo.png') }}");
                            }
                            $('#companyAddress').text(data.address);
                            $('#companyNumber').text(data.number);
                            $('#companyEmail').text(data.email);
                            $('#companyContactPerson').text(data.contact_person);
                            $('#companyContactPersonNumber').text(data.contact_person_number);
                        } else {
                            $('#showRow').css('display', 'none');
                            errorMessage(
                                "Clinic with this refer_code not available!");
                        }
                    },
                });
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
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
    <script src="{{ asset('site/assets/js/circle-progress.min.js') }}"></script>
@endsection
