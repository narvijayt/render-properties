@extends('pub.profile.layouts.profile')

@section('title', 'Refinance Leads')

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
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Received On</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            
            <tbody>
            @if ($showLeads)
                @if (!$leads->isEmpty())
                    @php $currentIndex = 1; @endphp
                    @foreach ($leads as $lead)
                        <tr>
                            <th scope="row">{{ $currentIndex }}</th>
                            <td>{{ $lead->firstName ?? 'N/A' }}</td>
                            <td>{{ $lead->lastName ?? 'N/A' }}</td>
                            <td>{{ $lead->email ?? 'N/A' }}</td>
                            <td>{{ $lead->phone_number ?? 'N/A' }}</td>
                            <td>{{ $lead->created_at->format('d M, Y') }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('pub.profile.leads.refinance.view', [ 'lead_id' => $lead->id ]) }}">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @php $currentIndex++; @endphp
                    @endforeach

                @else
                    <tr>
                        <td colspan="7" class="text-center">
                            <p>There are no leads available in your state.</p>
                        </td>
                    </tr>
                @endif

            @else
                <tr>
                    <td colspan="7" class="text-center subscription-text">
                        @if ($role === 'broker')
                            <p><i class="fa fa-fw fa-lock"></i>Please upgrade your subscription to access the lead details.</p>
                        @endif
                    </td>
                </tr>
            @endif


            </tbody>
        </table>
        <script src="{{ env('APP_URL')/js/admin/demo.js}}"></script>

    </div>
</div>
@endsection