@extends('pub.profile.layouts.profile')

@section('title', 'Leads')

@section('page_content')
<div class="row">
    <div class="col-md-12">
        <table class="table" style="background: #eee;">
            @if ($showLeads)
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
            @endif
            <tbody>
                @if ($showLeads)
                    @if (!$leads->isEmpty())
                        @php $currentIndex = 1; @endphp
                        @foreach ($leads as $lead)
                            <tr>
                                <th scope="row">{{ $currentIndex }}</th>
                                <td>{{ $lead->firstName }}</td>
                                <td>{{ $lead->lastName }}</td>
                                <td>{{ $lead->email }}</td>
                                <td>{{ $lead->phoneNumber }}</td>
                                <td>{{ $lead->city }}</td>
                                <td>{{ ucfirst($lead->formPropertyType) }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('pub.profile.leads.view', [ 'lead_id' => $lead->id ]) }}">
                                        <i class="fa fa-fw fa-eye"></i>
                                    </a>
                                </td>
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
                @else
                    <tr>
                        <td colspan="8" class="text-center">
                            @if ($role === 'realtor')
                                <p>Please match with someone to view the lead details.</p>
                            @elseif ($role === 'broker')
                                <p>Please upgrade your subscription to access the lead details.</p>
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
