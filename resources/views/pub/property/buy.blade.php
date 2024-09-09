@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends("layouts.app")
@section('title', 'Buy Property')
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
  <h1 class="banner-title">Find your Dream Home with <br> Top Realtors</h1>
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
            
            <form class="form-prevent-multiple-submits" method="POST" action="{{ route('property.store') }}" enctype="multipart/form-data" >
                {{csrf_field()}}
                <div class="container p-3 mb-3">
                    <h3 class="text-center">Complete the form below to connect with the best Realtors in your area, <br> ready to help you find your dream home.</h3>
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

                    <!-- Address -->
                    <div class="row mt-1">
                        <div class="col-md-12 mb-1">
                            <p><b>Address</b></p>
                            <!-- Street Address -->
                            <div class="row">
                                <div class="col-lg-6 mb-1">
                                    <input type="text" class="form-control" name="streetAddress" placeholder="Street Address" value="{{ old('streetAddress', '') }}">
                                </div>
                                <div class="col-lg-6 mb-1">
                                    <input type="text" class="form-control" name="streetAddressLine2" placeholder="Street Address Line 2" value="{{ old('streetAddressLine2', '') }}">
                                </div>
                            </div>

                            <!-- City, State -->
                            <div class="row">
                                <div class="col-lg-6 mb-1">
                                    <input type="text" class="form-control" name="city" placeholder="City" value="{{ old('city', '') }}">
                                </div>
                                <!-- <div class="col-lg-6 mb-1">
                                    <input type="text" class="form-control" name="state" placeholder="State / Province" value="{{ old('state', '') }}">
                                </div> -->
                                <div class="col-lg-3 mb-1">
                                    <select id="state" class="form-control" name="state">
                                        <option value="">Choose a state</option>
                                        @foreach($states::all() as $abbr => $stateName)
                                            <option value="{{ $abbr }}" {{ collect(old('state'))->contains($abbr) ? 'selected' : '' }}>{{ $stateName }}</option>
                                        @endforeach
                                    </select>    
                                </div>
                            </div>
                            
                            <!-- City, State and Zip Code | Country -->
                            <div class="row">
                                <div class="col-lg-6 mb-1">
                                    <input type="text" class="form-control" name="postal_code" placeholder="Postal / Zip Code" value="{{ old('postal_code', '') }}">
                                </div>
                            </div>

                        </div>
                    </div>                    

                    <!-- Own or Rent? | Time frame for moving -->
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <!-- Do you currently Own or Rent? -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <p><b>Do you currently Own or Rent?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="currentlyOwnOrRent" aria-label="Select Own or Rent">
                                            <option value="" {{ old('currentlyOwnOrRent') == '' ? 'selected' : '' }}>Please Select</option>
                                            <option value="Own" {{ old('currentlyOwnOrRent') == 'Own' ? 'selected' : '' }}>Own</option>
                                            <option value="Rent" {{ old('currentlyOwnOrRent') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- What is your timeframe for moving? -->
                                <div class="col-lg-6">
                                    <p><b>What is your timeframe for moving?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="timeframeForMoving" aria-label="Select Timeframe for moving">
                                            <option value="" {{ old('timeframeForMoving') == '' ? 'selected' : '' }}>Please Select</option>
                                            <option value="1 week" {{ old('timeframeForMoving') == '1 week' ? 'selected' : '' }}>1 week</option>
                                            <option value="1 month" {{ old('timeframeForMoving') == '1 month' ? 'selected' : '' }}>1 month</option>
                                            <option value="6 months" {{ old('timeframeForMoving') == '6 months' ? 'selected' : '' }}>6 months</option>
                                            <option value="1 Undecided" {{ old('timeframeForMoving') == '1 Undecided' ? 'selected' : '' }}>1 Undecided</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- How many bedrooms do you need? | How many bathrooms do you need? -->
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <!-- How many bedrooms do you need? -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <p><b>How many bedrooms do you need?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="numberOfBedrooms" aria-label="Select Bedrooms">
                                            <option value="" {{ old('numberOfBedrooms') == '' ? 'selected' : '' }}>Please Select</option>
                                            <option value="1" {{ old('numberOfBedrooms') == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('numberOfBedrooms') == '2' ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ old('numberOfBedrooms') == '3' ? 'selected' : '' }}>3</option>
                                            <option value="4" {{ old('numberOfBedrooms') == '4' ? 'selected' : '' }}>4</option>
                                            <option value="5+" {{ old('numberOfBedrooms') == '5+' ? 'selected' : '' }}>5+</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- How many bathrooms do you need? -->
                                <div class="col-lg-6">
                                    <p><b>How many bathrooms do you need?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="numberOfBathrooms" aria-label="Select Bathrooms">
                                            <option value="" {{ old('numberOfBathrooms') == '' ? 'selected' : '' }}>Please Select</option>
                                            <option value="1" {{ old('numberOfBathrooms') == '1' ? 'selected' : '' }}>1</option>
                                            <option value="1.5" {{ old('numberOfBathrooms') == '1.5' ? 'selected' : '' }}>1.5</option>
                                            <option value="2" {{ old('numberOfBathrooms') == '2' ? 'selected' : '' }}>2</option>
                                            <option value="2.5" {{ old('numberOfBathrooms') == '2.5' ? 'selected' : '' }}>2.5</option>
                                            <option value="3" {{ old('numberOfBathrooms') == '3' ? 'selected' : '' }}>3</option>
                                            <option value="3.5" {{ old('numberOfBathrooms') == '3.5' ? 'selected' : '' }}>3.5</option>
                                            <option value="4+" {{ old('numberOfBathrooms') == '4+' ? 'selected' : '' }}>4+</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- What size garage do you need? | What is your price range? -->
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <div class="row">                                
                                <!-- What is your price range? -->
                                <div class="col-lg-6">
                                    <p><b>What is your price range?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="priceRange" aria-label="Select Price Range">
                                            <option value="" {{ old('priceRange') == '' ? 'selected' : '' }}>Please Select</option>
                                            <option value="Under $100,000" {{ old('priceRange') == 'Under $100,000' ? 'selected' : '' }}>Under $100,000</option>
                                            <option value="$100,000 to $150,000" {{ old('priceRange') == '$100,000 to $150,000' ? 'selected' : '' }}>$100,000 to $150,000</option>
                                            <option value="$150,000 to $200,000" {{ old('priceRange') == '$150,000 to $200,000' ? 'selected' : '' }}>$150,000 to $200,000</option>
                                            <option value="$200,000 to $250,000" {{ old('priceRange') == '$200,000 to $250,000' ? 'selected' : '' }}>$200,000 to $250,000</option>
                                            <option value="$250,000 to $300,000" {{ old('priceRange') == '$250,000 to $300,000' ? 'selected' : '' }}>$250,000 to $300,000</option>
                                            <option value="$300,000+" {{ old('priceRange') == '$300,000+' ? 'selected' : '' }}>$300,000+</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- Have you been preapproved for a mortgage? | Do you need to sell a home before you buy? -->
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <!-- Have you been preapproved for a mortgage? -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <p><b>Have you been preapproved for a mortgage?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="preapprovedForMontage" aria-label="Select Preapproved for a Mortgage">
                                            <option value="" {{ old('preapprovedForMontage') == '' ? 'selected' : '' }}>Please Select</option>
                                            <option value="Yes" {{ old('preapprovedForMontage') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="No" {{ old('preapprovedForMontage') == 'No' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Do you need to sell a home before you buy? -->
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Do you need to sell a home before you buy?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="sellHomeBeforeBuy" aria-label="Select sell a home before you buy">
                                            <option value="" {{ old('sellHomeBeforeBuy') == '' ? 'selected' : '' }}>Please Select</option>
                                            <option value="Yes" {{ old('sellHomeBeforeBuy') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="No" {{ old('sellHomeBeforeBuy') == 'No' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Is there anything else that will help us find your new home ?-->
                    <div class="row">
                        <div class="col-lg-12 mb-1">
                            <p><b>Is there anything else that will help us find your new home?</b></p>
                            <textarea class="form-control" name="helpsFindingHomeDesc" rows="5" >{{ old('helpsFindingHomeDesc', '') }}</textarea>
                        </div>
                    </div>

                    <!-- Recaptcha -->
                    <script src="https://www.google.com/recaptcha/api.js"></script>
                    <div class="form-group row recaptcha-row">
                        <div class="col-md-6 offset-md-4">
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
                        <input type="hidden" name="formPropertyType" value="buy" />
                        <button type="submit" class="btn py-4 text-white navbar__button navbar__button--register form-submit-btn form-prevent-multiple-submits"><span>SUBMIT</span></button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts-footer')
    <script type="text/javascript">
        (function(){
            $('.form-prevent-multiple-submits').on('submit', function(){
                $('.form-prevent-multiple-submits').attr('disabled','true');
            })
        })();
    </script>
@endpush