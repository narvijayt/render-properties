@extends("layouts.app")
@section('title', 'Sell your property')
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
    <p class="sell_buy_banner_text"><b>Sell your home with the best Realtors</b></p>
</div>

<!-- Form -->
<div class="row justify-content-center align-items-center p-2">
    <div class="card col-md-8">
        <div class="card-body p-3">
            @if(session()->has('success'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
            @endif

            @if(session()->has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
            @endif

            <form action="{{ route('property.sell.store') }}" method="POST">
                <div class="container">
                    <!-- First and Last name section -->
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <input type="text" class="form-control" placeholder="First Name">
                        </div>
                        <div class="col-md-4 mb-1">
                            <input type="text" class="form-control" placeholder="Last Name">
                        </div>
                    </div>

                    <!-- Email and phone number section -->
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <input type="email" class="form-control" placeholder="E-mail">
                        </div>
                        <div class="col-md-4 mb-1">
                            <input type="text" class="form-control" placeholder="Phone Number">
                        </div>
                    </div>

                    <!-- Best Time To Contact You | How Soon Do You Need To Sell -->
                    <div class="row">
                        <!-- Best Time To Contact You -->
                        <div class="col-md-4 mb-1">
                            <p><b>Best Time To Contact You</b></p>
                            <div class="row p-0 justify-content-start">
                                <div class="form-check col-md-4">
                                    <input class="form-check-input" type="checkbox" id="morning">
                                    <label style="font-weight: normal" class="form-check-label" for="morning">
                                        Morning
                                    </label>
                                </div>
                                <div class="form-check col-md-4">
                                    <input class="form-check-input" type="checkbox" id="afternoon">
                                    <label style="font-weight: normal" class="form-check-label fw-normal" for="afternoon">
                                        Afternoon
                                    </label>
                                </div>
                                <div class="form-check col-md-4">
                                    <input class="form-check-input" type="checkbox" id="evening">
                                    <label style="font-weight: normal" class="form-check-label" for="evening">
                                        Evening
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- How Soon Do You Need To Sell -->
                        <div class="col-md-4 mb-1">
                            <p><b>How Soon Do You Need To Sell</b></p>
                            <div class="row">
                                <div class="form-check col-md-4">
                                    <input class="form-check-input" type="checkbox" id="asap">
                                    <label style="font-weight: normal" class="form-check-label" for="asap">
                                        As Soon As Possible
                                    </label>
                                </div>
                                <div class="form-check col-md-4">
                                    <input class="form-check-input" type="checkbox" id="30days">
                                    <label style="font-weight: normal" class="form-check-label" for="30days">
                                        Within 30 Days
                                    </label>
                                </div>
                                <div class="form-check col-md-4">
                                    <input class="form-check-input" type="checkbox" id="90days">
                                    <label style="font-weight: normal" class="form-check-label" for="90days">
                                        Within 90 Days
                                    </label>
                                </div>
                                <div class="form-check col-md-4">
                                    <input class="form-check-input" type="checkbox" id="options">
                                    <label style="font-weight: normal" class="form-check-label" for="options">
                                        I'm Looking at Options
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Do You Currently Live in the House | Would you like a free home valuation? -->
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <p><b>Do You Currently Live in the House</b></p>
                            <div class="row">
                                <div class="form-check form-check-inline col-md-2">
                                    <input class="form-check-input" type="radio" name="liveInHouse" id="yesLive" value="yes">
                                    <label style="font-weight: normal" class="form-check-label" for="yesLive">Yes</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2">
                                    <input class="form-check-input" type="radio" name="liveInHouse" id="noLive" value="no">
                                    <label style="font-weight: normal" class="form-check-label" for="noLive">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-1">
                            <p><b>Would you like a free home valuation?</b></p>
                            <div class="row">
                                <div class="form-check form-check-inline col-md-2">
                                    <input class="form-check-input" type="radio" name="freeValuation" id="yesValuation" value="yes">
                                    <label style="font-weight: normal" class="form-check-label" for="yesValuation">Yes</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2">
                                    <input class="form-check-input" type="radio" name="freeValuation" id="noValuation" value="no">
                                    <label style="font-weight: normal" class="form-check-label" for="noValuation">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Would you like to offer a buyer agent commission? -->
                    <div class="row">
                        <div class="col-md-8 mb-1">
                            <p><b>Would you like to offer a buyer agent commission? The recent NAR settlement no longer requires it, though it can still be beneficial. The choice is yours as the seller.</b></p>
                            <div class="row">
                                <div class="form-check form-check-inline col-md-1">
                                    <input class="form-check-input" type="radio" name="offerCommission" id="yesCommission" value="yes">
                                    <label style="font-weight: normal" class="form-check-label" for="yesCommission">Yes</label>
                                </div>
                                <div class="form-check form-check-inline col-md-1">
                                    <input class="form-check-input" type="radio" name="offerCommission" id="noCommission" value="no">
                                    <label style="font-weight: normal" class="form-check-label" for="noCommission">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Why Are You Selling? -->
                    <div class="row">
                        <div class="col-md-8 mb-1">
                            <p><b>Why Are You Selling?</b></p>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    
                    <!-- What Type of Property? -->
                    <div class="row">
                        <div class="col-md-8 mb-1">
                            <p><b>What Type of Property?</b></p>
                            <select class="form-control" aria-label="Select Property">
                                <option selected>Please Select</option>
                                <option value="1">Property Type I</option>
                                <option value="2">Property Type II</option>
                                <option value="3">Property Type III</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row">
                        <div class="col-md-8 mb-1">
                            <p><b>Address</b></p>
                            <!-- Street Address -->
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <input type="text" class="form-control" placeholder="Street Address">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <input type="text" class="form-control" placeholder="Street Address Line 2">
                                </div>
                            </div>

                            <!-- City, State and Zip Code -->
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <input type="text" class="form-control" placeholder="City">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <input type="text" class="form-control" placeholder="State / Province">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <input type="text" class="form-control" placeholder="Postal / Zip Code">
                                </div>
                            </div>

                        </div>
                    </div>

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