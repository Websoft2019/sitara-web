@extends('site.template')
@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Schedule Timings</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('clinic.home') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Schedule Timings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    @include('clinic.navbar', ['activePage' => 'clinicschedule'])
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Schedule Timings</h4>
                                    <div class="profile-box">
                                        <div class="row">
                                            <div class="content">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div class="row"
                                                                        style="display:flex; align-items: center;">
                                                                        <div class="col-md-8">
                                                                            <div
                                                                                class="bd-example bd-example-padded-bottom">
                                                                                <a href="#"
                                                                                    class="btn btn-sm bg-danger-light"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#clinicschedule">Add
                                                                                    Schedule</a>


                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <form action="" method="GET">
                                                                                {{-- @csrf --}}
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <input type="month"
                                                                                            id="datepicker" name="month"
                                                                                            class="form-control"
                                                                                            placeholder="Select Months"
                                                                                            value="{{ $monthyear->format('Y-m') }}"
                                                                                            autocomplete="off" />
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <button type="submit"
                                                                                            class="btn btn-success">
                                                                                            <i class="fas fa-search"
                                                                                                style=""></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Add Time --}}
                                                                @if (!$dates->isEmpty())
                                                                    <div class="container">
                                                                        <form method="POST" action="{{ route('clinic.postSetTimeForWeekend') }}"
                                                                            enctype="multipart/form-data">
                                                                            @csrf
                                                                            <h3>Add Time for this weekend</h3>
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label for="time">Open</label>
                                                                                        <input type="time"
                                                                                            class="form-control"
                                                                                            id="time" name="openTime"
                                                                                            value="" required>
                                                                                        @if ($errors->has('openTime'))
                                                                                            <span class="text-danger"
                                                                                                style="font-style: italic;">
                                                                                                <small
                                                                                                    style="font-weight: bold">{{ $errors->first('timeOpen') }}</small>
                                                                                            </span>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label for="time">Close</label>
                                                                                        <input type="time"
                                                                                            class="form-control"
                                                                                            id="time" name="closeTime"
                                                                                            value="" required>
                                                                                        @if ($errors->has('closeTime'))
                                                                                            <span class="text-danger"
                                                                                                style="font-style: italic;">
                                                                                                <small
                                                                                                    style="font-weight: bold">{{ $errors->first('closeTime') }}</small>
                                                                                            </span>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <input type="submit" class="btn btn-success"
                                                                                value="Add Time">
                                                                        </form>
                                                                    </div>
                                                                @endif

                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        @foreach ($dates as $date)
                                                                            <div class="col-md-6 mb-3">
                                                                                <div class="accordion"
                                                                                    id="accordionExample">
                                                                                    <div class="accordion-item">
                                                                                        <h2 class="accordion-header"
                                                                                            id="headingOne">
                                                                                            <button class="accordion-button"
                                                                                                type="button"
                                                                                                data-bs-toggle="collapse"
                                                                                                data-bs-target="#collapseOne-{{ $date->id }}"
                                                                                                aria-expanded="true"
                                                                                                aria-controls="collapseOne-{{ $date->id }}">
                                                                                                {{ date('D, M d, Y', strtotime($date->date)) }}
                                                                                            </button>
                                                                                        </h2>
                                                                                        <div id="collapseOne-{{ $date->id }}"
                                                                                            class="accordion-collapse collapse"
                                                                                            aria-labelledby="headingOne"
                                                                                            data-bs-parent="#accordionExample">
                                                                                            <div class="accordion-body">
                                                                                                <div class="row">
                                                                                                    @foreach ($date->getScheduleTimeFromScheduleDate->sortBy('time') as $time)
                                                                                                        <div
                                                                                                            class="col-md-4 mb-3">
                                                                                                            <div
                                                                                                                class="btn-group me-1">
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    class="btn btn-info w-100 dropdown-toggle"
                                                                                                                    data-bs-toggle="dropdown"
                                                                                                                    aria-haspopup="true"
                                                                                                                    aria-expanded="false">{{ date('h:i A', strtotime($time->time)) }}</button>
                                                                                                                <div class="dropdown-menu"
                                                                                                                    style="">
                                                                                                                    <a class="dropdown-item"
                                                                                                                        href="{{ route('clinic.getDeleteScheduleTime', $time->id) }}">Delete</a>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>
                                                                                                    @endforeach
                                                                                                    <div
                                                                                                        class="col-md-4 mb-3">
                                                                                                        <a href="#"
                                                                                                            class="btn w-100 bg-danger-light"
                                                                                                            data-bs-toggle="modal"
                                                                                                            data-bs-target="#addtime-{{ $date->id }}">Add
                                                                                                            Time</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('model')
    @foreach ($dates as $date)
        <div class="modal fade custom-modal" id="addtime-{{ $date->id }}" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Add Time on
                            <b>{{ date('D, M d, Y', strtotime($date->date)) }}</b>
                        </h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('clinic.postAddTime', $date->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input type="time" class="form-control" id="time" name="time" value=""
                                    required>
                                @if ($errors->has('time'))
                                    <span class="text-danger" style="font-style: italic;">
                                        <small style="font-weight: bold">{{ $errors->first('time') }}</small>
                                    </span>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-success" value="Add Time">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal fade custom-modal" id="clinicschedule" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Schedule</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('clinic.postAddScheduleDate') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ old('date') }}" required>
                            @if ($errors->has('date'))
                                <span class="text-danger" style="font-style: italic;">
                                    <small style="font-weight: bold">{{ $errors->first('date') }}</small>
                                </span>
                            @endif
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
@endsection
@section('js')
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

    <script src="{{ asset('site/assets/plugins/select2/js/select2.min.js') }}"></script>
@stop
