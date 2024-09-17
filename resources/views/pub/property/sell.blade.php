@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends("layouts.app")
@section('title', 'Sell Property')
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
    <h1 class="banner-title">Sell your home with the <br>  best Realtors</h1>
    </div>
</div>

<!-- Form -->
<div class="row justify-content-center align-items-center p-2">
    <div class="card property-form-outer">
        <div class="card-body">
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
            
            <form id="sell_property_form" class="form-prevent-multiple-submits" action="{{ route('property.store') }}" method="POST">
                {{csrf_field()}}
                <div class="container p-3 mb-3">
                    <h3 class="text-center">Connect with top Realtors in your area to maximize your home's value. <br> Fill out the form below to get started!</h3>
                    <!-- First and Last name section -->
                    <div class="row">
                        <div class="col-lg-6 mb-1">
                            <input type="text" class="form-control" name="firstName" placeholder="First Name" value="{{ old('firstName', '') }}">
                        </div>
                        <div class="col-lg-6 mb-1">
                            <input type="text" class="form-control" name="lastName" placeholder="Last Name" value="{{ old('lastName', '') }}">
                        </div>
                    </div>

                    <!-- Email and phone number section -->
                    <div class="row">
                        <div class="col-lg-6 mb-1">
                            <input type="email" class="form-control" name="email" placeholder="E-mail" value="{{ old('email', '') }}">
                        </div>
                        <div class="col-lg-6 mb-1">
                            <input type="text" class="form-control" name="phoneNumber" placeholder="Phone Number" value="{{ old('phoneNumber', '') }}">
                        </div>
                    </div>

                    <!-- Best Time To Contact You | How Soon Do You Need To Sell -->
                    <div class="row">
                        <!-- Best Time To Contact You -->
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-1">
                            <p><b>Best Time To Contact You</b></p>
                            <div class="p-0 check-d-flex">
                                <div class="form-check">
                                    <input class="check-input" type="checkbox" name="timeToContact[morning]" value="Morning" id="morning" {{ old('timeToContact.morning') == 'Morning' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="check-label" for="morning">
                                        Morning
                                    </label>
                                </div>
                                <div class="form-check ">
                                    <input class="check-input" type="checkbox" name="timeToContact[afternoon]" value="Afternoon" id="afternoon" {{ old('timeToContact.afternoon') == 'Afternoon' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="check-label fw-normal" for="afternoon">
                                        Afternoon
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="check-input" type="checkbox" name="timeToContact[evening]" value="Evening" id="evening" {{ old('timeToContact.evening') == 'Evening' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="check-label" for="evening">
                                        Evening
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- How Soon Do You Need To Sell -->
                        <div class="col-lg-6 mb-1">
                            <p><b>How Soon Do You Need To Sell</b></p>
                            <div class="p-0 check-d-flex">
                                <div class="form-check">
                                    <input class="check-input" type="checkbox" name="sellUrgency[asap]" value="As Soon As Possible" id="asap" {{ old('sellUrgency.asap') == 'As Soon As Possible' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="check-label" for="asap">
                                        As Soon As Possible
                                    </label>
                                </div>
								
                                <div class="form-check">
                                    <input class="check-input" type="checkbox" name="sellUrgency[30days]" value="Within 30 Days" id="30days" {{ old('sellUrgency.30days') == 'Within 30 Days' ? 'checked' : '' }} >
                                    <label style="font-weight: normal" class="check-label" for="30days">
                                        Within 30 Days
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="check-input" type="checkbox" name="sellUrgency[90days]" value="Within 90 Days" id="90days" {{ old('sellUrgency.90days') == 'Within 90 Days' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="check-label" for="90days">
                                        Within 90 Days
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="check-input" type="checkbox" name="sellUrgency[options]" value="I'm Looking at Options" id="options" {{ old('sellUrgency.options') == 'I\'m Looking at Options' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="check-label" for="options">
                                        I'm Looking at Options
                                    </label>
                                </div>
                            </div>
								
                        </div>
                    </div>


                    <!-- Do You Currently Live in the House | Would you like a free home valuation? -->
                    <div class="row">
                        <div class="col-lg-6 mb-1">
                            <p><b>Do You Currently Live in the House</b></p>
                            <div class="check-d-flex">
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="liveInHouse" id="yesLive" value="Yes" {{ old('liveInHouse') == 'Yes' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="form-check-label" for="yesLive">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="liveInHouse" id="noLive" value="No" {{ old('liveInHouse') == 'No' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="form-check-label" for="noLive">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-1">
                            <p><b>Would you like a free home valuation?</b></p>
                            <div class="check-d-flex">
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="freeValuation" id="yesValuation" value="Yes" {{ old('freeValuation') == 'Yes' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="form-check-label" for="yesValuation">Yes</label>
                                </div>
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="freeValuation" id="noValuation" value="No" {{ old('freeValuation') == 'No' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="form-check-label" for="noValuation">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Would you like to offer a buyer agent commission? -->
                    <div class="row">
                        <div class="col-lg-12 mb-1">
                            <p><b>Would you like to offer a buyer agent commission? The recent NAR settlement no longer requires it, though it can still be beneficial. The choice is yours as the seller.</b></p>
                            <div class=" check-d-flex">
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="offerCommission" id="yesCommission" value="Yes" {{ old('offerCommission') == 'Yes' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="form-check-label" for="yesCommission">Yes</label>
                                </div>
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="offerCommission" id="noCommission" value="No" {{ old('offerCommission') == 'No' ? 'checked' : '' }}>
                                    <label style="font-weight: normal" class="form-check-label" for="noCommission">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Why Are You Selling? -->
                    <div class="row">
                        <div class="col-lg-12 mb-1">
                            <p><b>Why Are You Selling?</b></p>
                            <textarea class="form-control" name="whyAreYouSelling" rows="3">{{ old('whyAreYouSelling', '') }}</textarea>
                        </div>
                    </div>
                    
                    <!-- What Type of Property? -->
                    <div class="row">
                        <div class="col-lg-12 mb-1 pt-1">
                            <p><b>What Type of Property?</b></p>
                            <select class="form-control" name="propertyType" aria-label="Select Property">
                                <option value="" {{ old('propertyType') == '' ? 'selected' : '' }}>Please Select</option>
                                <option value="Single Family House" {{ old('propertyType') == 'Single Family House' ? 'selected' : '' }}>Single Family House</option>
                                <option value="Condo" {{ old('propertyType') == 'Condo' ? 'selected' : '' }}>Condo</option>
                                <option value="Town Home" {{ old('propertyType') == 'Town Home' ? 'selected' : '' }}>Town Home</option>
                                <option value="Manufactured Home" {{ old('propertyType') == 'Manufactured Home' ? 'selected' : '' }}>Manufactured Home</option>
                                <option value="Other" {{ old('propertyType') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row">
                        <div class="col-lg-12 mb-1 pt-1">
                            <p><b>Address</b></p>
                            <!-- Street Address -->
                            <div class="row">
                                <div class="col-lg-6 mb-1">
                                    <input type="text" class="form-control" name="streetAddress" placeholder="Street Address" value="{{ old('streetAddress','') }}">
                                </div>
                                <div class="col-lg-6 mb-1">
                                    <input type="text" class="form-control" name="streetAddressLine2" placeholder="Street Address Line 2" value="{{ old('streetAddressLine2','') }}">
                                </div>
                            </div>

                            <!-- City, State and Zip Code -->
                            <div class="row">
                                <div class="col-lg-6 mb-1">
                                    <input type="text" class="form-control" name="city" placeholder="City" value="{{ old('city','') }}">
                                </div>
                                <!-- <div class="col-lg-3 mb-1">
                                    <input type="text" class="form-control" name="state" placeholder="State / Province" value="{{ old('state','') }}">
                                </div> -->
                                <div class="col-lg-3 mb-1">
                                    <select id="state" class="form-control" name="state">
                                        <option value="">Choose a state</option>
                                        @foreach($states::all() as $abbr => $stateName)
                                            <option value="{{ $abbr }}" {{ collect(old('state'))->contains($abbr) ? 'selected' : '' }}>{{ $stateName }}</option>
                                        @endforeach
                                    </select>    
                                </div>

                                <div class="col-lg-3 mb-1">
                                    <input type="text" class="form-control" name="postal_code" placeholder="Postal / Zip Code" value="{{ old('postal_code','') }}">
                                </div>
                            </div>

                        </div>
                    </div>

                    <script src="https://www.google.com/recaptcha/api.js"></script>
                    <div class="form-group row recaptcha-row">
                        <div class="col-lg-6 offset-lg-4">
                            <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                            <span class="msg-error error"></span>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="invalid-feedback" style="display: block;">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Submit -->
                    <div class="text-center col-lg-12 mt-1">
                        <input type="hidden" name="formPropertyType" value="sell" />
                        <button type="submit" class="btn py-4 text-white navbar__button navbar__button--register form-submit-btn form-prevent-multiple-submits"><span>SUBMIT</span></button>
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
@endsection

@push('scripts-footer')
    <script type="text/javascript">
        // Hide Loader as its Intial State
        $('.loader-container').hide();

        $("#sell_property_form").validate({
            rules: {
                firstName: {
                    required: true 
                },
                lastName: {
                    required: true
                },
                phoneNumber: {
                    required: true,
                    regex: /^(\+1\s?)?(\(?\d{3}\)?[\s.-]?)?\d{3}[\s.-]?\d{4}$/
                },
                streetAddress: {
                    required: true
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                postal_code: {
                    required: true,
                    regex: /^[0-9]*$/
                },
            },
            messages: {
                firstName:{
                    required: "Please enter a first name.",
                },
                lastName:{
                    required: "Please enter a last name.",
                },
                phoneNumber:{
                    required: "Please enter a phone number.",
                    regex: "Please enter a valid phone number format."
                },
                streetAddress:{
                    required: "Please enter a street address.",
                },
                city:{
                    required: "Please enter a city.",
                },
                state:{
                    required: "Please select a state.",
                },
                postal_code:{
                    required: "Please enter a postal code.",
                    regex: "Please enter a valid zip code."
                },
            },
            submitHandler: function(form) {
                $('.form-prevent-multiple-submits').attr('disabled','true');
                $('.loader-container').show();
                $('.navbar__button--register').attr('style', 'background-color: gray !important');
                $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                form.submit();
            }
        });

        // Add a custom validator for regex rule
        $.validator.addMethod("regex", function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Please check your input.");
    </script>
@endpush