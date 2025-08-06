<div class="bd-example">
    @if($active_linked_clinics->count())
        @foreach($active_linked_clinics as $active_linked_clinic)
            <button type="button" class="btn btn-success btn-sm">{{$active_linked_clinic->getClinicFromCompanyClinic->name}}</button>
        @endforeach
    @else
        <p>No clinic is linked to this company at the moment.</p>
    @endif
</div>