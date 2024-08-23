@extends('pub.profile.layouts.profile')

@section('title', 'Lead Form')

@section('page_content')

<div class="row justify-content-center align-items-center p-2">
    <div class="card view-lead-form">
        <div class="card-body">

            <div class="container p-3">
                <!-- First name section -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <a class="btn btn-primary" href="{{ route('pub.profile.leads') }}"> 
                            <i class="fa fa-fw fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <!-- First name section -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <h5>First Name</h5>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <h6>{{ $lead->firstName }}</h6>
                    </div>
                </div>

                <!-- Last name section -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <h5>Last Name</h5>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <h6>{{ $lead->lastName }}</h6>
                    </div>
                </div>

                <!-- Email section -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <h5>Email</h5>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <h6>{{ $lead->email }}</h6>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <h5>Phone Number</h5>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <h6>{{ $lead->phoneNumber }}</h6>
                    </div>
                </div>

                <!-- Street Address -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <h5>Street Address</h5>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <h6>{{ $lead->streetAddress }}</h6>
                    </div>
                </div>
                
                <!-- Street Address Line 2 -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <h5>Street Address Line 2</h5>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <h6>{{ $lead->streetAddressLine2 }}</h6>
                    </div>
                </div>

                <!-- City -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <h5>City</h5>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <h6>{{ $lead->city }}</h6>
                    </div>
                </div>

                <!-- State -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <h5>State</h5>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <h6>{{ $lead->state }}</h6>
                    </div>
                </div>

                <!-- Postal Code -->
                <div class="row">
                    <div class="col-lg-3 mb-1">
                        <h5>Postal Code</h5>
                    </div>
                    <div class="col-lg-6 mb-1">
                        <h6>{{ $lead->postal_code }}</h6>
                    </div>
                </div>

                @if ($lead->formPropertyType === "sell")
                    @php
                        $timeToContact = json_decode($lead->timeToContact, true);
                        $timeToContact = implode(", ", array_values($timeToContact));
                        $sellUrgency = json_decode($lead->sellUrgency, true);
                        $sellUrgency = implode(", ", array_values($sellUrgency));
                    @endphp
                    
                    <!-- Best Time To Contact You -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>Best Time To Contact You</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            @if (!empty($timeToContact))
                                <h6>{{ $timeToContact}}</h6>
                            @endif
                        </div>
                    </div>

                    <!-- How Soon Do You Need To Sell -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>How Soon Do You Need To Sell</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $sellUrgency }}</h6>
                        </div>
                    </div>

                    <!-- Do You Currently Live in the House -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>Do You Currently Live in the House</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->liveInHouse }}</h6>
                        </div>
                    </div>

                    <!-- Would you like a free home valuation? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>Would you like a free home valuation?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->freeValuation }}</h6>
                        </div>
                    </div>

                    <!-- Would you like to offer a buyer agent commission? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>Would you like to offer a buyer agent commission? The recent NAR settlement no longer requires it, though it can still be beneficial. The choice is yours as the seller.</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->offerCommission }}</h6>
                        </div>
                    </div>

                    <!-- Why Are You Selling? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>Why Are You Selling?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->whyAreYouSelling }}</h6>
                        </div>
                    </div>

                    <!-- What Type of Property? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>What Type of Property?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->propertyType }}</h6>
                        </div>
                    </div>

                @endif


                @if ($lead->formPropertyType === "buy")
                    <!-- Do you currently Own or Rent? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>Do you currently Own or Rent?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->currentlyOwnOrRent }}</h6>
                        </div>
                    </div>

                    <!-- What is your timeframe for moving? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>What is your timeframe for moving?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->timeframeForMoving }}</h6>
                        </div>
                    </div>

                     <!-- How many bedrooms do you need? -->
                     <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>How many bedrooms do you need?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->numberOfBedrooms }}</h6>
                        </div>
                    </div>

                    <!-- How many bathrooms do you need? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>How many bathrooms do you need?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->numberOfBathrooms }}</h6>
                        </div>
                    </div>

                    <!-- What is your price range? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>What is your price range?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->priceRange }}</h6>
                        </div>
                    </div>

                    <!-- Have you been preapproved for a mortgage? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>Have you been preapproved for a mortgage?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->preapprovedForMontage }}</h6>
                        </div>
                    </div>

                    <!-- Do you need to sell a home before you buy? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>Do you need to sell a home before you buy?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->sellHomeBeforeBuy }}</h6>
                        </div>
                    </div>
                    
                    <!-- Is there anything else that will help us find your new home? -->
                    <div class="row">
                        <div class="col-lg-3 mb-1">
                            <h5>Is there anything else that will help us find your new home?</h5>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <h6>{{ $lead->helpsFindingHomeDesc }}</h6>
                        </div>
                    </div>

                @endif

            </div>
        </div>
    </div>
</div>
    
@endsection