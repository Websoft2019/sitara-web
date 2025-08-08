<div class="card">
    <div class="card-header">
       <h4 class="card-title mb-0">Clinic Visit</h4>
    </div>
    @php
        $Cappointments = App\Models\Appointment::where('clinic_user_id', '!=', Null)->where('status', 'completed')->get();

    @endphp
    <div class="card-body" style="min-height: 800px">
        <div class="row">
            <div class="experience-box">
                <ul class="experience-list">
                    @foreach($Cappointments as $cappointment)
                        @php
                            $clinicinfo = App\Models\Clinic::find($cappointment->clinic_id);
                            $cappointmenttime = App\Models\ScheduleTime::find($cappointment->schedule_time_id);
                            $appointmentdate = App\Models\ScheduleDate::find($cappointmenttime->schedule_date_id);
                        @endphp
                        <li>
                            <div class="experience-user">
                                <div class="before-circle"></div>
                            </div>
                            <div class="experience-content">
                                <div class="timeline-content">
                                    <a href="#/" class="name">{{$clinicinfo->name}}</a>
                                    <span class="time">{{$appointmentdate->date->format('d M, Y')}}</span>
                                    <div><a href="{{ route("clinic.getCheckUpPanel", $cappointment->id) }}" class="">View</a></div>
                                </div>
                             </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>