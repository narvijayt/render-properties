@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends("layouts.app")
@section('title', 'Refinance Your Home Loan')
@section('meta')
@if(!empty($meta))
@if(!is_null($meta->description))
{{ meta('description',html_entity_decode(strip_tags($meta->description))) }}
@else
{{ meta('description', config('seo.description')) }}
@endif
@if(!is_null($meta->keywords))
{{ meta('keywords', html_entity_decode(strip_tags($meta->keyword)))}}
@else
{{ meta('keywords', config('seo.keyword')) }}
@endif
@else
{{ meta('description', config('seo.description')) }}
{{ meta('keywords', config('seo.keyword')) }}
@endif
{{ openGraph('og:title', 'Home') }}
{{ openGraph('og:type', 'product') }}
{{ openGraph('og:url', Request::url()) }}
{{ openGraph('og:image', config('seo.image')) }}
{{ openGraph('og:description', config('seo.description')) }}
{{ openGraph('og:site_name', config('app.name')) }}
{{ openGraph('fb:admins', config('seo.facebook_id')) }}
{{ twitter('twitter:card', 'summary') }}
{{ twitter('twitter:site', config('seo.twitter_handle')) }}
{{ twitter('twitter:title', 'Home') }}
{{ twitter('twitter:description', config('seo.description')) }}
{{ twitter('twitter:creator', config('seo.twitter_handle')) }}
{{ twitter('twitter:image', config('seo.image')) }}
{{ googlePlus('name', 'Home') }}
{{ googlePlus('description', config('seo.description')) }}
{{ googlePlus('image', config('seo.image')) }}
@endsection

@section("content")
<!-- Banner -->
<div class="banner privacy">
    <div class="container">
        <h1 class="banner-title"> The Federal Reserve Has <br> Lowered Rates!</h1>
    </div>
</div>

<!-- Form -->
<div class="row">
    <div class="card property-form-outer property-Step-form">
        <div class="container form-header">
            <h4 class="text-center mb-1">Now is the perfect time to take advantage of these lower rates and refinance your home loan. Start saving today by securing a better rate and lowering your monthly payments. Don’t miss out—fill out the form now and see how much you could save!</h4>
        </div>

        <div class="container form-header">
            @if(session()->has('success'))
                <div class="mb-1">
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
                </div>
            @endif
            
            @if(session()->has('error'))
                <div class="mb-1">
                    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
                </div>
            @endif
        </div>

        <!-- Progress Bar and Volume -->
        <div class="progress-outer">
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" id="progress-bar" style="width: 0%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="container p-3 mb-3">
                <div class="multi-step-form">
                    <form id="multi-step-form" class="form-prevent-multiple-submits" action="{{ route('refinance.store') }}" method="POST">
                        {{ csrf_field() }}
                        <!-- Step 1 -->
                        <div class="step" id="step-1">
                            <h2 class="text-center">What type of property you are refinancing?</h2>
                            <div class="step-inner">
                                <div class="text-center mt-2">
                                    <span class="show-error error-message">
                                        <i class="fa fa-exclamation-circle"></i> Please select an option.
                                    </span>
                                </div>
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="type_of_property" id="single_family_house" value="Single Family Home" autocomplete="off" {{ old('type_of_property') == 'Single Family Home' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="single_family_house">Single Family Home</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="type_of_property" id="condominium" value="Condominium" autocomplete="off" {{ old('type_of_property') == 'Condominium' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="condominium">Condominium</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="type_of_property" id="townhome" value="Townhome" autocomplete="off" {{ old('type_of_property') == 'Townhome' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="townhome">Townhome</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="type_of_property" id="multi_family_home" value="Multi-Family Home" autocomplete="off" {{ old('type_of_property') == 'Multi-Family Home' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="multi_family_home">Multi-Family Home</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="step-btn">
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="step" id="step-2">
                            <h2 class="text-center">Estimate your credit score.</h2>
                            <div class="text-center mt-2">
                                <span class="show-error error-message">
                                    <i class="fa fa-exclamation-circle"></i> Please select an option.
                                </span>
                            </div>
                            
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="estimate_credit_score" id="excellent_740+" value="Excellent 740+" autocomplete="off" {{ old('estimate_credit_score') == 'Excellent 740+' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="excellent_740+">Excellent 740+</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="estimate_credit_score" id="good_700-739" value="Good 700-739" autocomplete="off" {{ old('estimate_credit_score') == 'Good 700-739' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="good_700-739">Good 700-739</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="estimate_credit_score" id="average_660-699" value="Average 660-699" autocomplete="off" {{ old('estimate_credit_score') == 'Average 660-699' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="average_660-699">Average 660-699</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="estimate_credit_score" id="fair_660-659" value="Fair 600-659" autocomplete="off" {{ old('estimate_credit_score') == 'Fair 600-659' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="fair_660-659">Fair 600-659</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="estimate_credit_score" id="poor_<_600" value="Poor < 600" autocomplete="off" {{ old('estimate_credit_score') == 'Poor < 600' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="poor_<_600">Poor < 600</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="step" id="step-3">
                            <h2 class="text-center">How will this property be used?</h2>
                            <div class="text-center mt-2">
                                <span class="show-error error-message">
                                    <i class="fa fa-exclamation-circle"></i> Please select an option.
                                </span>
                            </div>
                            
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="how_property_used" id="primary_home" value="Primary Home" autocomplete="off" {{ old('how_property_used') == 'Primary Home' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="primary_home">Primary Home</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="how_property_used" id="secondary_home" value="Secondary Home" autocomplete="off" {{ old('how_property_used') == 'Secondary Home' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="secondary_home">Secondary Home</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="how_property_used" id="rental_property" value="Rental Property" autocomplete="off" {{ old('how_property_used') == 'Rental Property' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="rental_property">Rental Property</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 4-->
                        <div class="step" id="step-4">
                            <h2 class="text-center mt-2">Do you have second mortgage?</h2>
                            <div class="text-center">
                                <span class="show-error error-message">
                                    <i class="fa fa-exclamation-circle"></i> Please select an option.
                                </span>
                            </div>

                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="have_second_mortgage" id="second_mortage_yes" value="Yes" autocomplete="off" {{ old('have_second_mortgage') == 'Yes' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="second_mortage_yes">Yes</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="have_second_mortgage" id="second_mortage_no" value="No" autocomplete="off" {{ old('have_second_mortgage') == 'No' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="second_mortage_no">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 5-->
                        <div class="step" id="step-5">
                            <h2 class="text-center">Would you like to borrow additional cash?</h2>
                            <div class="step-inner">
                                <div class="price-slider-container">
                                    <input type="range" id="borrow_additional_cash_price_range_in" name="borrow_additional_cash" min="0" max="100000" value="{{ old('borrow_additional_cash', '0') }}" step="1" oninput="updatePrice('borrow_additional_cash_price_range_in', 'borrow_additional_cash_price_output', this.value)">
                                    <label for="borrow_additional_cash_price_range_in">$<span id="borrow_additional_cash_price_output">{{ old('borrow_additional_cash', '0')  }}</span></label>
                                </div>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 6-->
                        <div class="step" id="step-6">
                            <h2 class="text-center">What is your employment status?</h2>
                            <div class="text-center mt-2">
                                <span class="show-error error-message">
                                    <i class="fa fa-exclamation-circle"></i> Please select an option.
                                </span>
                            </div>

                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="employment_status" id="employed" value="Employed" autocomplete="off" {{ old('employment_status') == 'Employed' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="employed">Employed</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="employment_status" id="not_employed" value="Not Employed" autocomplete="off" {{ old('employment_status') == 'Not Employed' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="not_employed">Not Employed</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="employment_status" id="self_employed" value="Self Employed" autocomplete="off" {{ old('employment_status') == 'Self Employed' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="self_employed">Self Employed</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="employment_status" id="military" value="Military" autocomplete="off" {{ old('employment_status') == 'Military' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="military">Military</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="employment_status" id="other" value="Other" autocomplete="off" {{ old('employment_status') == 'Other' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="other">Other</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 7-->
                        <div class="step" id="step-7">
                            <h2 class="text-center">Bankruptcy, short sale, or foreclosure <br> in the last 3 years?</h2>
                            <div class="text-center mt-2">
                                <span class="show-error error-message">
                                    <i class="fa fa-exclamation-circle"></i> Please select an option.
                                </span>
                            </div>

                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="bankruptcy_shortscale_foreclosure" id="bankruptcy_yes" value="Yes" autocomplete="off" {{ old('bankruptcy_shortscale_foreclosure') == 'Yes' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="bankruptcy_yes">Yes</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="bankruptcy_shortscale_foreclosure" id="bankruptcy_no" value="No" autocomplete="off" {{ old('bankruptcy_shortscale_foreclosure') == 'No' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="bankruptcy_no">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 8-->
                        <div class="step" id="step-8">
                            <h2 class="text-center">Can you show proof of income?</h2>
                            <div class="text-center mt-2">
                                <span class="show-error error-message">
                                    <i class="fa fa-exclamation-circle"></i> Please select an option.
                                </span>
                            </div>
                            
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="proof_of_income" id="proof_of_income_yes" value="Yes" autocomplete="off" {{ old('proof_of_income') == 'Yes' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="proof_of_income_yes">Yes</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="proof_of_income" id="proof_of_income_no" value="No" autocomplete="off" {{ old('proof_of_income') == 'No' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="proof_of_income_no">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 9-->
                        <div class="step" id="step-9">
                            <h2 class="text-center">What is your average monthly income?</h2>
                            <div class="step-inner">
                                <div class="price-slider-container">
                                    <input type="range" id="average_monthly_income_input" name="average_monthly_income" min="0" max="50000" value="{{ old('average_monthly_income', '0') }}" step="1" oninput="updatePrice('average_monthly_income_input', 'average_monthly_income_output', this.value)">
                                    <label for="average_monthly_income_input">$<span id="average_monthly_income_output">{{ old('average_monthly_income', '0') }}</span></label>
                                </div>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 10-->
                        <div class="step" id="step-10">
                            <h2 class="text-center">What are your average monthly expenses?</h2>
                            <div class="step-inner">
                                <div class="price-slider-container">
                                    <input type="range" id="average_monthly_expenses_input" name="average_monthly_expenses" min="0" max="50000" value="{{ old('average_monthly_expenses', '0') }}" step="1" oninput="updatePrice('average_monthly_expenses_input', 'average_monthly_expenses_output', this.value)">
                                    <label for="average_monthly_expenses_input">$<span id="average_monthly_expenses_output">{{ old('average_monthly_expenses', '0') }}</span></label>
                                </div>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 11-->
                        <div class="step" id="step-11">
                            <h2 class="text-center">Do you currently have an FHA loan?</h2>
                            <div class="text-center mt-2">
                                <span class="show-error error-message">
                                    <i class="fa fa-exclamation-circle"></i> Please select an option.
                                </span>
                            </div>

                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="have_an_fha_loan" id="have_an_fha_loan_yes" value="Yes" autocomplete="off" {{ old('have_an_fha_loan') == 'Yes' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="have_an_fha_loan_yes">Yes</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="have_an_fha_loan" id="have_an_fha_loan_no" value="No" autocomplete="off" {{ old('have_an_fha_loan') == 'No' ? 'checked' : '' }} >
                                            <label class="btn btn-secondary" for="have_an_fha_loan_no">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 12-->
                        <div class="step" id="step-12">
                            <div class="step-inner">
                                <div class="form-box">
                                    <div class="mb-0">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" value="{{ old('firstName', '') }}"  placeholder="Enter your first name">
                                        <div class="text-left">
                                            <span id="firstName-error" class="s11-error-message"></span>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" value="{{ old('lastName', '') }}" placeholder="Enter your last name">
                                        <div class="text-left">
                                            <span id="lastName-error" class="s11-error-message"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-box">
                                    <div class="mb-0">
                                        <label for="email" class="form-label">What is your email address?</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', '') }}" placeholder="Enter your email">
                                        <div class="text-left">
                                            <span id="email-error" class="s11-error-message"></span>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label for="phone" class="form-label">What is your phone number?</label>
                                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber', '') }}" placeholder="Enter your phone number">
                                        <div class="text-left">
                                            <span id="phoneNumber-error" class="s11-error-message"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-box">
                                    <div class="mb-0">
                                        <label for="email" class="form-label">Street Address</label>
                                        <input type="text" class="form-control" id="streetAddress" name="streetAddress" placeholder="Street Address" value="{{ old('streetAddress','') }}">
                                        <div class="text-left">
                                            <span id="streetAddress-error" class="s11-error-message"></span>
                                        </div>

                                    </div>
                                    <div class="mb-0">
                                        <label for="phone" class="form-label">Street Address Line 2</label>
                                        <input type="text" class="form-control" name="streetAddressLine2" placeholder="Street Address Line 2" value="{{ old('streetAddressLine2','') }}">
                                    </div>
                                </div>
                                
                                <div class="form-box">
                                    <div class="mb-0">
                                        <label for="email" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city_field" name="city" placeholder="City" value="{{ old('city','') }}">
                                        <div class="text-left">
                                            <span id="city-error" class="s11-error-message"></span>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <label for="phone" id="state" class="form-label">State</label>
                                        <select class="form-control" id="state" name="state">
                                            <option value="">Choose a state</option>
                                            @foreach($states::all() as $abbr => $stateName)
                                                <option value="{{ $abbr }}" {{ collect(old('state'))->contains($abbr) ? 'selected' : '' }}>{{ $stateName }}</option>
                                            @endforeach
                                        </select>
                                        <div class="text-left">
                                            <span id="state-error" class="s11-error-message"></span>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <label for="email" class="form-label">Postal / Zip Code</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal / Zip Code" value="{{ old('postal_code','') }}">
                                        <div class="text-left">
                                            <span id="postalCode-error" class="s11-error-message"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-box recaptcha-box">
                                    <script src="https://www.google.com/recaptcha/api.js"></script>
                                    <div class="mb-0 recaptcha-container">
                                        <div class="g-recaptcha" 
                                            data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}" 
                                            data-callback="onRecaptchaSuccess"
                                            data-expired-callback="onRecaptchaExpired"></div>
                                        <span class="msg-error error"></span>
                                        <span id="gcaptcha-error" class="s11-error-message"></span>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" style="display: block;">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-text">
                                    <p>I agree to be contacted via call, email and text. To opt-out, you can reply “stop” at any time.</p>
                                </div>
                                
                                <div class="step-btn">
                                    <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                    <button type="submit" class="btn btn-primary refinance-form-submit-btn form-prevent-multiple-submits">Get My Quote </button>
                                </div>

                                <!-- Form On Submit Loader -->
                                <div class="text-center col-lg-12 mt-2 loader-container">
                                    <span class="form-loader"></span>
                                    <h5>Please wait, your form is being submitted...</h5>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts-footer')
<script>
$(document).ready(function() {
    var currentStep = 1;

    // Show the first step
    $('#step-' + currentStep).addClass('step-active');

    // Next button click event
    $('.next').click(function() {
        $('#step-' + currentStep).removeClass('step-active');
        currentStep++;
        $('#step-' + currentStep).addClass('step-active');
    });

    // Previous button click event
    $('.prev').click(function() {
        $('#step-' + currentStep).removeClass('step-active');
        currentStep--;
        $('#step-' + currentStep).addClass('step-active');
    });
});
</script>


<script>

function updatePrice(sliderId, outputId, value) {
    document.getElementById(outputId).innerText = value;
}

</script>

<script>
  let currentStep = 0; // Initial step
  const steps = document.getElementsByClassName("step");
  const progressBar = document.getElementById("progress-bar");

  // Show the first step
  showStep(currentStep);

  function showStep(step) {
    // Hide all steps
    for (let i = 0; i < steps.length; i++) {
      steps[i].style.display = "none";
    }
    // Show the current step
    steps[step].style.display = "block";
    
    // Update the progress bar
    let progress = (step / (steps.length - 1)) * 100;
    progressBar.style.width = progress + "%";
    //progressBar.innerHTML = `Step ${step + 1} of ${steps.length}`;

    // Adjust the button visibility
    if (step == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }

    if (step == steps.length - 1) {
      document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
      document.getElementById("nextBtn").innerHTML = "Next";
    }
  }

    function isRadioSelected(radioGroupName) {
        const radioGroup = document.getElementsByName(radioGroupName);

        for (let i = 0; i < radioGroup.length; i++) {
            if (radioGroup[i].checked) {
                return true;
            }
        }

        return false; 
    }

    function nextStep() {
        if (currentStep == 4 || currentStep == 8 || currentStep == 9) {
            currentStep++;
            showStep(currentStep);

        } else {
            const targetElement = event.target;

            // Find closest step container
            const closestElement = targetElement.closest('.step-btn').closest('.step');

            // Get all radio properties
            let input = closestElement.querySelectorAll('input[type="radio"]');

            // Get first input name
            let value = input[0].name;

            // Check if radio button is checked or not
            const selectedProperty = closestElement.querySelector(`input[name="${value}"]:checked`);

            // Move steps if property is selected
            if (selectedProperty) {
                currentStep++;
                showStep(currentStep);
                closestElement.querySelector('.error-message').style.display = "none";

            } else {
                closestElement.querySelector('.error-message').style.display = "block";
            }
        }
    }


    function prevStep() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    }
</script>

<script type="text/javascript">
    // Hide Loader as its Initial State
    $('.loader-container').hide();

    var formSubmitted = false;

    // Function to validate form fields
    function validateForm() {
        const firstName = $("input[name=firstName]").val();
        const lastName = $("input[name='lastName']").val();
        const phoneNumber = $("input[name='phoneNumber']").val();
        const streetAddress = $("input[name='streetAddress']").val();
        const city = $("input[name='city']").val();
        const state = $('select[name="state"]').val();
        const postalCode = $("input[name='postal_code']").val();
        var google_captcha_response = grecaptcha.getResponse();

        const firstNameError = $('#firstName-error');
        const lastNameError = $("#lastName-error");
        const phoneNumberError = $("#phoneNumber-error");
        const streetAddressError = $("#streetAddress-error");
        const cityError = $("#city-error");
        const stateError = $("#state-error");
        const postalCodeError = $("#postalCode-error");
        const gCaptchaError = $("#gcaptcha-error");

        // Clear previous errors
        firstNameError.text("");
        lastNameError.text("");
        phoneNumberError.text("");
        streetAddressError.text("");
        cityError.text("");
        stateError.text("");
        postalCodeError.text("");
        gCaptchaError.text("");

        let isValid = true;

        // Only show errors if form has been submitted at least once
        if (formSubmitted) {
            if (firstName === "" || /\d/.test(firstName)) {
                firstNameError.html("<i class='fa fa-exclamation-circle'></i> Please enter a valid first name.");
                isValid = false;
            }

            if (lastName === "" || /\d/.test(lastName)) {
                lastNameError.html("<i class='fa fa-exclamation-circle'></i> Please enter a last name.");
                isValid = false;
            }

            if (phoneNumber === "") {
                phoneNumberError.html("<i class='fa fa-exclamation-circle'></i> Please enter a phone number.");
                isValid = false;
            } else if (/^(\+1\s?)?(\(?\d{3}\)?[\s.-]?)?\d{3}[\s.-]?\d{4}$/.test(phoneNumber) == false) {
                phoneNumberError.html("<i class='fa fa-exclamation-circle'></i> Please enter a valid phone number.");
                isValid = false;
            }

            if (streetAddress === "") {
                streetAddressError.html("<i class='fa fa-exclamation-circle'></i> Please enter a street address.");
                isValid = false;
            }

            if (city === "") {
                cityError.html("<i class='fa fa-exclamation-circle'></i> Please enter a city.");
                isValid = false;
            }

            if (state === "") {
                stateError.html("<i class='fa fa-exclamation-circle'></i> Please select a state.");
                isValid = false;
            }

            if (postalCode === "") {
                postalCodeError.html("<i class='fa fa-exclamation-circle'></i> Please enter a postal code.");
                isValid = false;
            } else if (/^[0-9]*$/.test(postalCode) == false) {
                postalCodeError.html("<i class='fa fa-exclamation-circle'></i> Please enter a valid postal code.");
                isValid = false;
            }

            if (google_captcha_response === "") {
                gCaptchaError.html("<i class='fa fa-exclamation-circle'></i> Please verify that you are not a robot.");
                isValid = false;
            }
        }

        return isValid;
    }

    $(document).ready(function() {
        // Only validate after form submission attempt
        $("#firstName, #lastName, #phoneNumber, #streetAddress, #city_field, #state, #postal_code").on("input", function() {
            if (formSubmitted) {
                validateForm();
            }
        });
    });

    // Function to handle successful reCAPTCHA response
    function onRecaptchaSuccess(token) {
        // Clear any existing error message when reCAPTCHA is successful
        $('#gcaptcha-error').text('');
    }

    // Function to handle expired reCAPTCHA (optional)
    function onRecaptchaExpired() {
        $('#gcaptcha-error').html("<i class='fa fa-exclamation-circle'></i> reCAPTCHA expired. Please try again.");
    }

    // Disable Submit Button and Show Loader on Form Submit.
    (function(){
        $('.form-prevent-multiple-submits').on('submit', function(event){
            formSubmitted = true; // Mark form as submitted after first attempt

            if (!validateForm()) {
                event.preventDefault(); // Prevent submission if validation fails
                return false;
            }

            $('.form-prevent-multiple-submits').attr('disabled', 'true');
            $('.loader-container').show();
            $('.refinance-form-submit-btn').attr('style', 'background-color: gray !important');
            $("html, body").animate({ scrollTop: $(document).height() - $(window).height() });
        });
    })();
</script>



@endpush