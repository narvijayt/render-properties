@extends('pub.profile.layouts.profile')

@section('title', 'Leads')

@section('page_content')
<div class="row">
    <div class="col-md-12">
        @if(session()->has('success'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
        @endif

        @if(session()->has('error'))
            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
        @endif

        <table id="leads_listing_table" class="table table-striped table-bordered" style="background: #eee;" >
            <thead>
                <tr>
                    <th scope="col">S. No.</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">City</th>
                    <th scope="col">Sell / Buy</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                
            @if (!$leads->isEmpty())
                @php $currentIndex = 1; @endphp
                @foreach ($leads as $lead)
                    @php
                        $checkVisibility = $lead->areLeadsVisible->whereIn('notification_type', ['lead_unmatched', 'subscription_upgrade']);
                        $rowClass = $checkVisibility->isNotEmpty() ? 'blurred-row' : '';
                    @endphp

                    <tr class="{{ $rowClass }}">
                        <th scope="row">{{ $currentIndex }}</th>
                        <td>{{ $lead->firstName }}</td>
                        <td>{{ $lead->lastName }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phoneNumber }}</td>
                        <td>{{ $lead->city }}</td>
                        <td>{{ ucfirst($lead->formPropertyType) }}</td>
                        <td>
                            @if ($checkVisibility->isNotEmpty())
                                <span class="text-muted">{{ $message }}</span>
                            @else
                                <a class="btn btn-primary" href="{{ route('pub.profile.leads.view', ['lead_id' => $lead->id]) }}">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            @endif
                        </td>

                        @if ($rowClass)
                            <tr>
                                <td class="subscription-text" colspan="8" class="text-center">
                                    @if ($user->user_type === "realtor")
                                        <p><i class="fa fa-fw fa-lock"></i>Please match with someone to view this lead.</p>
                                    @elseif ($user->user_type === "broker")
                                        <p><i class="fa fa-fw fa-lock"></i>Please upgrade your subscription to access this lead.</p>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tr>
                    
                    @php $currentIndex++; @endphp
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">
                        <p>There are no leads available in your city.</p>
                    </td>
                </tr>
            @endif


            </tbody>
        </table>
        <script src="{{ env('APP_URL')/js/admin/demo.js}}"></script>

    </div>
</div>
@endsection

<!-- @push('scripts-footer')
    <script src="{{ URL::asset ('js/admin/demo.js') }}"></script>
    <script src="http://127.0.0.1:8000/js/admin/datatables/jquery.dataTables.min.js"></script>
    <script src="http://127.0.0.1:8000/js/admin/datatables/dataTables.bootstrap.min.js"></script>
    <script src="http://127.0.0.1:8000/js/admin/admin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
    <script src="http://127.0.0.1:8000/js/admin/bootstrap/bootstrap.min.js"></script>
@endpush -->