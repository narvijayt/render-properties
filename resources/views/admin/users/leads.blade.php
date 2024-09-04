@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('admin.layouts.main')
@section('content')
<section class="content-header">
    <h1>User Leads</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Users</li>
        <li class="active">Leads</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="box">
                <div class="box-header">
                    <div class="col-md-10">
                        <h4>Leads Sent to <b>{{ $user->first_name.' '.$user->last_name }}</b></h4>
                    </div>
                    <div class="col-md-2 text-right">
                        <h4>Total: {{ $userLeads->count() }}</h4>
                    </div>
                </div>

                <div class="view-lead-box">
                    <table id="leads_listing_table" class="table table-striped table-bordered" style="background: #eee;" >
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Sell / Buy</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @if (!$userLeads->isEmpty())
                                @php $currentIndex = 1; @endphp
                                @foreach ($userLeads as $lead)
                                    @php $currentLead = $lead->propertyFormDetails()->first(); @endphp
                                    <tr>
                                        <th scope="row">{{ $currentIndex }}</th>
                                        <td>{{ $currentLead->firstName }}</td>
                                        <td>{{ $currentLead->lastName }}</td>
                                        <td>{{ $currentLead->email }}</td>
                                        <td>{{ $currentLead->phoneNumber ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($currentLead->formPropertyType) }}</td>
                                        <td>
                                            <a href="{{ route('admin.leads.view', [ 'lead_id' => $lead->property_form_id ]) }}">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @php $currentIndex++; @endphp
                                @endforeach
                            @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection