@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
    <h1>View Property Lead</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Leads</li>
            <li>Property</li>
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
                                        <td>{{ $lead->phoneNumber ?? 'N/A' }}</td>
                                    </tr>
                                    <!-- Street Address -->
                                    <tr>
                                        <th>Street Address</th>
                                        <td>{{ $lead->streetAddress ?? 'N/A' }}</td>
                                    </tr>
                                    <!-- Street Address Line 2 -->
                                    <tr>
                                        <th>Street Address Line 2</th>
                                        <td>{{ $lead->streetAddressLine2 ?? 'N/A' }}</td>
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

                                    @if ($lead->formPropertyType === "sell")
                                        @php
                                            $timeToContact = json_decode($lead->timeToContact, true);
                                            $timeToContact = implode(", ", array_values($timeToContact));
                                            $sellUrgency = json_decode($lead->sellUrgency, true);
                                            $sellUrgency = implode(", ", array_values($sellUrgency));
                                        @endphp
                                        
                                        <!-- Best Time To Contact You -->
                                        <tr>
                                            <th>Best Time To Contact You</th>
                                            <td>{{ $timeToContact ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- How Soon Do You Need To Sell -->
                                        <tr>
                                            <th>How Soon Do You Need To Sell</th>
                                            <td>{{ $sellUrgency ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- Do You Currently Live in the House -->
                                        <tr>
                                            <th>Do You Currently Live in the House</th>
                                            <td>{{ $lead->liveInHouse ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- Would you like a free home valuation? -->
                                        <tr>
                                            <th>Would you like a free home valuation?</th>
                                            <td>{{ $lead->freeValuation ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- Would you like to offer a buyer agent commission? The recent NAR settlement no longer requires it, though it can still be beneficial. The choice is yours as the seller. -->
                                        <tr>
                                            <th>Would you like to offer a buyer agent commission? The recent NAR settlement no longer requires it, though it can still be beneficial. The choice is yours as the seller.</th>
                                            <td>{{ $lead->offerCommission ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- Why Are You Selling? -->
                                        <tr>
                                            <th>Why Are You Selling?</th>
                                            <td>{{ $lead->whyAreYouSelling ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- What Type of Property? -->
                                        <tr>
                                            <th>What Type of Property?</th>
                                            <td>{{ $lead->propertyType ?? 'N/A' }}</td>
                                        </tr>

                                    @endif

                                    @if ($lead->formPropertyType === "buy")
                                        <!-- Do you currently Own or Rent? -->
                                        <tr>
                                            <th>Do you currently Own or Rent?</th>
                                            <td>{{ $lead->currentlyOwnOrRent ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- What is your timeframe for moving? -->
                                        <tr>
                                            <th>What is your timeframe for moving?</th>
                                            <td>{{ $lead->timeframeForMoving ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- How many bedrooms do you need? -->
                                        <tr>
                                            <th>How many bedrooms do you need?</th>
                                            <td>{{ $lead->numberOfBedrooms ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- How many bathrooms do you need? -->
                                        <tr>
                                            <th>How many bathrooms do you need?</th>
                                            <td>{{ $lead->numberOfBathrooms ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- What is your price range? -->
                                        <tr>
                                            <th>What is your price range?</th>
                                            <td>{{ $lead->priceRange ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- Have you been preapproved for a mortgage? -->
                                        <tr>
                                            <th>Have you been preapproved for a mortgage??</th>
                                            <td>{{ $lead->preapprovedForMontage ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- Do you need to sell a home before you buy? -->
                                        <tr>
                                            <th>Do you need to sell a home before you buy?</th>
                                            <td>{{ $lead->sellHomeBeforeBuy ?? 'N/A' }}</td>
                                        </tr>
                                        
                                        <!-- Is there anything else that will help us find your new home? -->
                                        <tr>
                                            <th>Is there anything else that will help us find your new home?</th>
                                            <td>{{ $lead->helpsFindingHomeDesc ?? 'N/A' }}</td>
                                        </tr>

                                    @endif

                                    <!-- Lead Form Type -->
                                    <tr>
                                        <th>Lead Form Type</th>
                                        <td>{{ ucfirst($lead->formPropertyType) }}</td>
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
                        'detailed_with_lead_matched' => 'Detailed (Matched REA)',
                        'lead_unmatched' => 'Unmatched REA',
                        'subscription_upgrade' => 'Subscription Upgrade',
                        'detailed' => 'Detailed (Paid Loan Officer)',
                    ];
                @endphp
                <!-- Lead Sent To -->
                <div class="box">
                    <div class="view-lead-box">
                        <h3 class="mb-2"><b>Lead Sent To :</b></h3>
                        <div class="d-flex">
                            @if(isset($richardTocadoLeads) && $richardTocadoLeads->isNotEmpty())
                                @if ($realtorSentLeads->isEmpty() && $brokerSentLeads->isNotEmpty()) 
                                    <h4 class="mb-3"><span><b class="lead-sent-title">Richard Tocado:&nbsp;</b> </span><span class="text-red">No Realtor found in this area.</span></h4>
                                @elseif ($realtorSentLeads->isNotEmpty() && $brokerSentLeads->isEmpty())
                                    <h4 class="mb-3"><span><b class="lead-sent-title">Richard Tocado:&nbsp;</b> </span><span class="text-red">No Loan Officer found in this area.</span></h4>
                                @elseif ($realtorSentLeads->isEmpty() && $brokerSentLeads->isEmpty())
                                    <h4 class="mb-3"><span><b class="lead-sent-title">Richard Tocado:&nbsp;</b> </span><span class="text-red">No Loan Officer or Realtor found in this area.</span></h4>
                                @endif
                            @endif

                            @if(isset($realtorSentLeads) && $realtorSentLeads->isNotEmpty())
                                <div>
                                    <h3 class="mb-2 lead-sent-title"><b>Realtors</b></h3>
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
                                            @php $currentIndex = (isset($_REQUEST['realtors']) && !empty($_REQUEST['realtors'])) ? ( ($_REQUEST['realtors']-1)*10) + 1 : 1; @endphp
                                            @foreach($realtorSentLeads as $lead)
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
                                        </tbody>
                                    </table>

                                    <!-- Pagination for Realtors Table -->
                                    <div class="text-right">
                                        <ul class="pagination pagination-sm" style="margin: 0;">
                                            {{ $realtorSentLeads->appends(request()->except('page'))->links() }}
                                        </ul>
                                    </div>

                                </div>
                            @endif

                            @if(isset($brokerSentLeads) && $brokerSentLeads->isNotEmpty())
                                <div>
                                    <h3 class="mb-2 lead-sent-title"><b>Brokers</b></h3>
                                    <table id="view_leads_listing_table2" class="table table-striped table-bordered" style="background: #eee;" >
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
                                        </tbody>
                                    </table>

                                    <!-- Pagination for Brokers Table -->
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