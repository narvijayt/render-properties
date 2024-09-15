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
                    <div class="col-md-12">
                        <h4>Leads Sent to <b>{{ $user->first_name.' '.$user->last_name }}</b></h4>
                    </div>
                </div>

                <div class="view-lead-box">
                    <div class="row justify-space-between">
                        <h3 class="mb-2 lead-sent-title col-md-6"><b>Property Form Leads</b></h3>
                        <h3 class="mb-2 lead-sent-title col-md-6 text-right"><b>Total:</b> {{ $property_lead_count }}</h3>            
                    </div>
                    <table id="view_leads_listing_table1" class="table table-striped table-bordered" style="background: #eee;" >
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Sell / Buy</th>
                                <th scope="col">Received On</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @if (!$userLeads->isEmpty())
                                @php $currentIndex = (isset($_REQUEST['property_leads']) && !empty($_REQUEST['property_leads'])) ? ( ($_REQUEST['property_leads']-1)*10) + 1 : 1; @endphp
                                @foreach ($userLeads as $lead)
                                    @php $currentLead = $lead->propertyFormDetails()->first(); @endphp
                                    <tr>
                                        <th scope="row">{{ $currentIndex }}</th>
                                        <td>{{ $currentLead->firstName ?? 'N/A' }}</td>
                                        <td>{{ $currentLead->lastName ?? 'N/A' }}</td>
                                        <td>{{ $currentLead->email ?? 'N/A' }}</td>
                                        <td>{{ $currentLead->phoneNumber ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($currentLead->formPropertyType) }}</td>
                                        <td>{{ $lead->created_at->format('d M, Y') . ' at ' .$lead->created_at->format('H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('admin.leads.property.view', [ 'lead_id' => $lead->property_form_id, 'user_id' => $user->user_id ]) }}">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @php $currentIndex++; @endphp
                                @endforeach
                            @endif
                            
                        </tbody>
                    </table>

                    <!-- Pagination for Brokers Table -->
                    <div class="text-right">
                        <ul class="pagination pagination-sm" style="margin: 0;">
                            {{ $userLeads->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                   
                </div>


                <div class="view-lead-box">
                    <div class="row justify-space-between">
                        <h3 class="mb-2 lead-sent-title col-md-6"><b>Refinance Form Leads</b></h3>
                        <h3 class="mb-2 lead-sent-title col-md-6 text-right"><b>Total:</b> {{ $refinance_lead_count }}</h3>            
                    </div>
                    <table id="view_leads_listing_table2" class="table table-striped table-bordered" style="background: #eee;" >
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
                            @if (!$user_refinance_leads->isEmpty())
                                @php $currentIndex = (isset($_REQUEST['refinance_leads']) && !empty($_REQUEST['refinance_leads'])) ? ( ($_REQUEST['refinance_leads']-1)*10) + 1 : 1; @endphp
                                @foreach ($user_refinance_leads as $lead)
                                    @php $currentLead = $lead->refinanceFormDetails()->first(); @endphp
                                    <tr>
                                        <th scope="row">{{ $currentIndex }}</th>
                                        <td>{{ $currentLead->firstName ?? 'N/A' }}</td>
                                        <td>{{ $currentLead->lastName ?? 'N/A' }}</td>
                                        <td>{{ $currentLead->email ?? 'N/A' }}</td>
                                        <td>{{ $currentLead->phoneNumber ?? 'N/A' }}</td>
                                        <td>{{ $lead->created_at->format('d M, Y') . ' at ' .$lead->created_at->format('H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('admin.leads.refinance.view', [ 'lead_id' => $lead->refinance_form_id, 'user_id' => $user->user_id ]) }}">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @php $currentIndex++; @endphp
                                @endforeach
                            @endif
                            
                        </tbody>
                    </table>
                    
                    <!-- Pagination for Brokers Table -->
                    <div class="text-right">
                        <ul class="pagination pagination-sm" style="margin: 0;">
                            {{ $user_refinance_leads->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                   
                </div>

            </div>
        </div>
    </div>
</section>
@endsection