@extends("layouts.app")
@section('title', 'Buy your property')
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
<div class="sell_buy_banner">
    <img src="/img/instant-access-bg.png" class="sell_buy_banner_img" style="height: 140px; width: 100%" alt="banner_bg" />
    <p class="sell_buy_banner_text"><b>Find your Dream Home with Top Realtors</b></p>
</div>

<!-- Form -->
<div class="row justify-content-center align-items-center p-3">
    <div class="card col-md-8">
        <div class="card-body p-2">
            @if(session()->has('success'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
            @endif

            @if(session()->has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
            @endif
            
            <form method="POST" action="{{ route('property.buy.store') }}">
                {{csrf_field()}}
                <div class="container">
                    <!-- First and Last name section -->
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <input type="text" class="form-control" name="firstName" placeholder="First Name">
                        </div>
                        <div class="col-md-4 mb-1">
                            <input type="text" class="form-control" name="lastName" placeholder="Last Name">
                        </div>
                    </div>

                    <!-- Email and phone number section -->
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <input type="email" class="form-control" name="email" placeholder="E-mail">
                        </div>
                        <div class="col-md-4 mb-1">
                            <input type="text" class="form-control" name="phoneNumber" placeholder="Phone Number">
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row mt-1">
                        <div class="col-md-12 mb-1">
                            <p><b>Address</b></p>
                            <!-- Street Address -->
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <input type="text" class="form-control" name="streetAddress" placeholder="Street Address">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <input type="text" class="form-control" name="streetAddressLine2" placeholder="Street Address Line 2">
                                </div>
                            </div>

                            <!-- City, State -->
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <input type="text" class="form-control" name="city" placeholder="City">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <input type="text" class="form-control" name="state" placeholder="State / Province">
                                </div>
                            </div>
                            
                            <!-- City, State and Zip Code | Country -->
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <input type="text" class="form-control" name="postal_code" placeholder="Postal / Zip Code">
                                </div>
                            </div>

                        </div>
                    </div>                    

                    <!-- Own or Rent? | Time frame for moving -->
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <!-- Do you currently Own or Rent? -->
                            <div class="row">
                                <div class="col-md-4">
                                    <p><b>Do you currently Own or Rent?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="currentlyOwnOrRent" aria-label="Select Own or Rent">
                                            <option value="" selected>Please Select</option>
                                            <option value="own">Own</option>
                                            <option value="rent">Rent</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- What is your timeframe for moving? -->
                                <div class="col-md-4">
                                    <p><b>What is your timeframe for moving?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="timeframeForMoving" aria-label="Select Timeframe for moving">
                                            <option value="" selected>Please Select</option>
                                            <option value="1 week">1 week</option>
                                            <option value="1 month">1 month</option>
                                            <option value="6 months">6 months</option>
                                            <option value="1 Undecided">1 Undecided</option>
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
                                <div class="col-md-4">
                                    <p><b>How many bedrooms do you need?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="numberOfBedrooms" aria-label="Select Bedrooms">
                                            <option value="" selected>Please Select</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5+">5+</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- How many bathrooms do you need? -->
                                <div class="col-md-4">
                                    <p><b>How many bathrooms do you need?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="numberOfBathrooms" aria-label="Select Bathrooms">
                                            <option value="" selected>Please Select</option>
                                            <option value="1">1</option>
                                            <option value="1.5">1.5</option>
                                            <option value="2">2</option>
                                            <option value="2.5">2.5</option>
                                            <option value="3">3</option>
                                            <option value="3.5">3.5</option>
                                            <option value="4+">4+</option>
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
                                <div class="col-md-4">
                                    <p><b>What is your price range?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="priceRange" aria-label="Select Price Range">
                                            <option value="" selected>Please Select</option>
                                            <option value="Under $100,000">Under $100,000</option>
                                            <option value="$100,000 to $150,000">$100,000 to $150,000</option>
                                            <option value="$150,000 to $200,000">$150,000 to $200,000</option>
                                            <option value="$200,000 to $250,000">$200,000 to $250,000</option>
                                            <option value="$250,000 to $300,000">$250,000 to $300,000</option>
                                            <option value="$300,000+">$300,000+</option>
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
                                <div class="col-md-4">
                                    <p><b>Have you been preapproved for a mortgage?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="preapprovedForMontage" aria-label="Select Preapproved for a Mortgage">
                                            <option value="" selected>Please Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Do you need to sell a home before you buy? -->
                                <div class="col-md-4">
                                    <p><b>Do you need to sell a home before you buy?</b></p>
                                    <div class="mb-1">
                                        <select class="form-control" name="sellHomeBeforeBuy" aria-label="Select sell a home before you buy">
                                            <option value="" selected>Please Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Is there anything else that will help us find your new home ?-->
                    <div class="row">
                        <div class="col-md-8 mb-1">
                            <p><b>Is there anything else that will help us find your new home?</b></p>
                            <textarea class="form-control" name="helpsFindingHomeDesc" rows="5"></textarea>
                        </div>
                    </div>

                    <!-- Send us a file-->
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <p><b>Send us a file</b></p>
                            <input type="file" name="file" name="file" />
                        </div>
                    </div>

                    <!-- Recaptcha -->
                    <script src="https://www.google.com/recaptcha/api.js"></script>
                    <div class="form-group row recaptcha-row">
                        <div class="col-md-6 offset-md-4">
                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                            <span class="msg-error error"></span>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="invalid-feedback" style="display: block;">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Submit -->
                    <div class="text-center col-md-8 mt-1">
                        <button type="submit" class="btn py-4 text-white navbar__button navbar__button--register form-submit-btn"><span>SUBMIT</span></button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection