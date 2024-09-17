@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
    <h1>View Refinance Lead</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Leads</li>
            <li>Refinance</li>
            <li class="active">View</li>
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
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                <div class="box">
                    <div class="view-lead-box">
                        <div class="p-2">
                            <!-- First name section -->
                            <div class="row mb-1">
                                <div class="col-lg-5 mb-1">
                                    <a class="btn btn-primary" href="{{ $prev_url }}"> 
                                        <i class="fa fa-fw fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered view-lead-detail-table" style="background: #eee;" >
                                <tbody>

                                    <!-- First Name -->
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{ $lead->firstName ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Last Name -->
                                    <tr>
                                        <th>Last Name</th>
                                        <td>{{ $lead->lastName ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Email -->
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $lead->email ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Phone Number -->
                                    <tr>
                                        <th>Phone Number</th>
                                        <td>{{ $lead->phone_number ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Street Address -->
                                    <tr>
                                        <th>Street Address</th>
                                        <td>{{ $lead->street_address ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Street Address Line 2 -->
                                    <tr>
                                        <th>Street Address Line 2</th>
                                        <td>{{ $lead->street_address_line_2 ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- City -->
                                    <tr>
                                        <th>City</th>
                                        <td>{{ $lead->city ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- State -->
                                    <tr>
                                        <th>State</th>
                                        <td>{{ $lead->state ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Postal Code -->
                                    <tr>
                                        <th>Postal Code</th>
                                        <td>{{ $lead->postal_code ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- What type of property you are refinancing? -->
                                    <tr>
                                        <th>What type of property you are refinancing?</th>
                                        <td>{{ $lead->type_of_property ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Estimate your credit score -->
                                    <tr>
                                        <th>Estimate your credit score</th>
                                        <td>{{ $lead->estimate_credit_score ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- How will this property be used? -->
                                    <tr>
                                        <th>How will this property be used?</th>
                                        <td>{{ $lead->how_property_used ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Do you have second mortgage? -->
                                    <tr>
                                        <th>Do you have second mortgage?</th>
                                        <td>{{ $lead->have_second_mortgage ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Would you like to borrow additional cash? -->
                                    <tr>
                                        <th>Would you like to borrow additional cash?</th>
                                        <td>{{ '$' . $lead->borrow_additional_cash ?? 'N/A' }}</td>
                                    </tr>

                                    <!--  What is your employment status? -->
                                    <tr>
                                        <th> What is your employment status?</th>
                                        <td>{{ $lead->employment_status ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Bankruptcy, short sale, or foreclosure in the last 3 years? -->
                                    <tr>
                                        <th>Bankruptcy, short sale, or foreclosure in the last 3 years?</th>
                                        <td>{{ $lead->bankruptcy_shortscale_foreclosure ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- Can you show proof of income? -->
                                    <tr>
                                        <th>Can you show proof of income?</th>
                                        <td>{{ $lead->bankruptcy_shortscale_foreclosure ?? 'N/A' }}</td>
                                    </tr>

                                    <!-- What is your average monthly income? -->
                                    <tr>
                                        <th>What is your average monthly income?</th>
                                        <td>{{ '$' . $lead->average_monthly_income ?? 'N/A' }}</td>
                                    </tr>

                                    <!--  What are your average monthly expenses? -->
                                    <tr>
                                        <th> What are your average monthly expenses?</th>
                                        <td>{{ '$' . $lead->average_monthly_expenses ?? 'N/A' }}</td>
                                    </tr>

                                    <!--  Do you currently have an FHA loan? -->
                                    <tr>
                                        <th> Do you currently have an FHA loan?</th>
                                        <td>{{ $lead->currently_have_fha_loan ?? 'N/A' }}</td>
                                    </tr>


                                    <!-- Lead Received On -->
                                    <tr>
                                        <th>Lead Received On</th>
                                        <td>{{ $lead->created_at->format('d M, Y') . ' at ' .$lead->created_at->format('H:i:s') }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @php
                    $getNotificationTypeDetails = [
                        'subscription_upgrade' => 'Subscription Upgrade',
                        'detailed_with_paid_loan_officer' => 'Detailed (Paid Loan Officer)',
                    ];
                @endphp

                <!-- Lead Sent To -->
                <div class="box">
                    <div class="view-lead-box">
                        <h3 class="mb-2"><b>Lead Sent To :</b></h3>
                        <div class="d-flex">
                            @if(isset($richardTocadoLeads) && $richardTocadoLeads->isNotEmpty() && $brokerSentLeads->isEmpty())
                                <h4 class="mb-3"><span><b class="lead-sent-title">Richard Tocado:&nbsp;</b> </span><span class="text-red">No Loan Officer found in this area.</span></h4>
                            @endif

                            @if(isset($brokerSentLeads) && $brokerSentLeads->isNotEmpty())
                                <div>
                                    <h3 class="mb-2 lead-sent-title"><b>Brokers</b></h3>
                                    <table id="view_leads_listing_table1" class="table table-striped table-bordered" style="background: #eee;" >
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Notification Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($brokerSentLeads) && $brokerSentLeads->isNotEmpty())
                                                @php $currentIndex = (isset($_REQUEST['brokers']) && !empty($_REQUEST['brokers'])) ? ( ($_REQUEST['brokers']-1)*10) + 1 : 1; @endphp
                                                @foreach($brokerSentLeads as $lead)
                                                    @php 
                                                        $lead_sent_detail = $lead->getAgentDetails()->first();
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $currentIndex++ }}</td>
                                                        <td>{{ $lead_sent_detail->first_name.' '.$lead_sent_detail->last_name }}</td>
                                                        <td>{{ $lead_sent_detail->email }}</td>
                                                        <td>{{ $lead_sent_detail->phone_number ?? 'N/A' }}</td>
                                                        <td>{{ $getNotificationTypeDetails[$lead->notification_type] ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>No Records Found.</tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    <!-- Pagination for Realtors Table -->
                                    <div class="text-right">
                                        <ul class="pagination pagination-sm" style="margin: 0;">
                                            {{ $brokerSentLeads->appends(request()->except('page'))->links() }}
                                        </ul>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection