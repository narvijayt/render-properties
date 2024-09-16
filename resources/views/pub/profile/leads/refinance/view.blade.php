@extends('pub.profile.layouts.profile')

@section('title', 'Refinance Lead Form')

@section('page_content')

<div class="row align-items-center p-2">
    <div class="card view-lead-form">
        <div class="card-body">

            <div class="container p-2">
                <!-- First name section -->
                <div class="row">
                    <div class="col-lg-5 mb-1">
                        <a class="btn btn-primary" href="{{ route('pub.profile.leads.refinance') }}"> 
                            <i class="fa fa-fw fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <!-- First name section -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>First Name</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->firstName ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Last name section -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Last Name</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->lastName ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Email section -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Email</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->email ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Phone Number</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->phone_number ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Street Address -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Street Address</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->street_address ?? 'N/A' }}</h6>
                    </div>
                </div>
                
                <!-- Street Address Line 2 -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Street Address Line 2</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->street_address_line_2 ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- City -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>City</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->city ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- State -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>State</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->state ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Postal Code -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Postal Code</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->postal_code ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- What type of property you are refinancing? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>What type of property you are refinancing?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->type_of_property ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Estimate your credit score. -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Estimate your credit score</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->estimate_credit_score ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- How will this property be used? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>How will this property be used?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->how_property_used ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Do you have second mortgage? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Do you have second mortgage?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->have_second_mortgage ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Would you like to borrow additional cash? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Would you like to borrow additional cash?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ '$' . $lead->borrow_additional_cash ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- What is your employment status? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>What is your employment status?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->employment_status ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Bankruptcy, short sale, or foreclosure in the last 3 years? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Bankruptcy, short sale, or foreclosure in the last 3 years?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->bankruptcy_shortscale_foreclosure ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Can you show proof of income? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Can you show proof of income?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->proof_of_income ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- What is your average monthly income? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>What is your average monthly income?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ '$' . $lead->average_monthly_income ?? 'N/A' }}</h6>
                    </div>
                </div>


                <!-- What are your average monthly expenses? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>What are your average monthly expenses?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ '$' . $lead->average_monthly_expenses ?? 'N/A' }}</h6>
                    </div>
                </div>


                <!-- Do you currently have an FHA loan? -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Do you currently have an FHA loan?</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->currently_have_fha_loan ?? 'N/A' }}</h6>
                    </div>
                </div>

                <!-- Lead Received On -->
                <div class="row">
                    <div class="col-lg-7">
                        <h5>Lead Received On</h5>
                    </div>
                    <div class="col-lg-5">
                        <h6>{{ $lead->created_at->format('d M, Y') . ' at ' .$lead->created_at->format('H:i:s') }}</h6>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
    
@endsection