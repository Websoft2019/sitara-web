<div class="bd-example">
    @if($active_linked_companies->count())
        @foreach($active_linked_companies as $active_linked_company)
            <button type="button" class="btn btn-success btn-sm">{{$active_linked_company->getClinicFromCompanyClinic->name}}</button>
        @endforeach
    @else
        <p>No company is linked to this clinic at the moment.</p>
    @endif
</div>