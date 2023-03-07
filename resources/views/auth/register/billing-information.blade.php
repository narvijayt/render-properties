@extends('layouts.app')

@section('title', 'Register')
@section('meta')
    @php
        $description = 'Register for Render'
    @endphp
    {{ meta('description', $description) }}
    {{ meta('keywords', 'Partial Registration, Browse Real Estate Agents near you, Claim your Zip Code, Content Marketing, Blogs & Podcast, SEM, Geo-fencing, Purchase Lending Tree Leads' ) }}
    {{ openGraph('og:title', 'Register') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}

    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Register') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}

    {{ googlePlus('name', 'Register') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')
    @component('pub.components.banner', ['banner_class' => 'lender'])
        <h1 class="banner-title">Billing</h1>
    @endcomponent
    <div class="container">
        <div class="row">
            <!----<div class="alert alert-success">
                         During this time of crisis. Render stands with our members. Until further notice all membership monthly payments will be waived at this time. 
                          </div>--->
                          
            @php
                $req = Request::segment(2);
                if(isset($req) && $req != '') {
                    echo '<div class="alert alert-info">
                          Please subscribe for Monthly/Yearly Subscription and browse Real Estate Agents near you.
                          </div>';
                }
            @endphp
			@if (Session::has('message'))
				<p class="alert alert-danger">
					{{ Session::get('message') }}
				</p>
			@endif
            <div class="billing-info">
               <!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payment-form">
                <!--<input type="hidden" name="custom" value="{{$user_id}}"/>
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="Q8KR3VVMK5WW8">

                    <input type="hidden" name="item_name" value="abc">
                    <input type="hidden" name="item_number" value="{{$user_id}}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="currency_code" value="USD">

                    <input type="hidden" name="return" value="https://www.render.properties/user-registration">

                    <input type="hidden" name="bn" value="PP-BuyNowBF">
                    <input type="hidden" name="rm" value="1">
                    <div class="col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" class="form-control" name="first_name" value="{{ $first_name }}"/>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" class="form-control" name="last_name" value="{{ $last_name }}"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" name="email" value="{{ $email }}"/>
                    </div>
                    <div class="col-md-6">
                        <label for="company">Company</label>
                        <input type="text" id="company" class="form-control" name="custom" value="{{ $firm_name }}"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <label for="address1">Billing Address1</label>
                        <input type="text" id="address1" class="form-control" name="address" placeholder="Billing Address 1"/>
                    </div>
                    <div class="col-md-6">
                        <label for="address2">Billing Address2</label>
                        <input type="text" id="address2" class="form-control" name="" placeholder="Billing Address 2"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <label for="billing_locality">City</label>
                        <input type="text" id="billing_locality" class="form-control" placeholder="City" name="" value="{{$city}}">
                    </div>
                    <div class="col-md-4">
                        <label for="billing_region">State</label>
                        <input type="text" id="billing_region" class="form-control" name="" placeholder="State" value="{{ $state }}"/>
                    </div>
                    <div class="col-md-4">
                        <label for="billing_postal_code">Zip</label>
                        <input type="text" id="billing_postal_code" class="form-control" name="" placeholder="Postal Code" value="{{ $zip }}"  />
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <h4>Subscription</h4>
                        <div class="form-group">
                            <select name="amount" id="amount" class="form-control">
                                <option value="59.00">Monthly - $59.00 per month</option>
                                <option value="590.00">Yearly - $590.00 per year</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br/>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-warning pull-right saveReg" value="Pay">
                        </div>
                    </div>
                </form>-->
				<form action="{{ url('/user-registration') }}" method="post" id="payment-form">
					<input type="hidden" name="user_id" value="{{$user_id}}" /> 
                    <div class="col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" class="form-control" name="first_name" value="{{ $first_name }}" required="" aria-required="true" />
					</div>
                    <div class="col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" class="form-control" name="last_name" value="{{ $last_name }}" required="" aria-required="true" />
					</div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" name="email" value="{{ $email }}" required="" aria-required="true" />
					</div>
                    <div class="col-md-6">
                        <label for="company">Company</label>
                        <input type="text" id="company" class="form-control" name="custom" value="{{ $firm_name }}"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <label for="address1">Billing Address1</label>
                        <input type="text" id="address1" class="form-control" name="address" placeholder="Billing Address 1" required="" aria-required="true"/>
					</div>
                    <div class="col-md-6">
                        <label for="address2">Billing Address2</label>
                        <input type="text" id="address2" class="form-control" name="address2" placeholder="Billing Address 2"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <label for="billing_locality">City</label>
                        <input type="text" id="billing_locality" class="form-control" placeholder="City" name="city" value="{{$city}}" required="" aria-required="true"/>
                    </div>
                    <div class="col-md-4">
                        <label for="billing_region">State</label>
                        <input type="text" id="billing_region" class="form-control" name="state" placeholder="State" value="{{ $state }}" required="" aria-required="true"/>
                    </div>
                    <div class="col-md-4">
                        <label for="billing_postal_code">Zip</label>
                        <input type="text" id="billing_postal_code" class="form-control" name="zip" placeholder="Postal Code" value="{{ $zip }}"  required="" aria-required="true"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <h4>Subscription</h4>
                        <div class="form-group">
                            <select name="amount" id="amount" class="form-control">
                                <option value="99.00">Monthly - $99.00 per month</option>
                                <option value="995.00">Yearly - $995.00 per year (Save 16% paying annual)</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
					<h6 style="font-size: 15px;">Your information is securely stored on Authorize.net using 256-bit bank grade encryption. Render does not store credit card information on their servers.</h6>
					<div class="col-md-6">
						<h6>Card Number</h6>
						<input type="number" name="card_num" id="card_num" class="form-control" placeholder="Credit/Debit Card Number" autocomplete="off" required="" aria-required="true">
					</div>
					<div class="col-md-6">
						<h6>Card Expiration Month</h6>
						<input type="text" name="exp_month" maxlength="2" class="form-control" id="card-expiry-month" placeholder="MM" required="" aria-required="true">
					</div>
					<div class="col-md-6" style="margin-bottom:34px;">
						<h6>Card Expiration Year</h6>
						<input type="text" name="exp_year" maxlength="4" class="form-control" id="card-expiry-year" placeholder="YYYY" required="" aria-required="true">
					</div>
					<div class="col-md-6">
						<h6>CVC Code</h6>
						<input type="text" name="cvc" id="card-cvc" maxlength="4" class="form-control" autocomplete="off" placeholder="CVC" required="" aria-required="true">
					</div>
                    <br/>	
                    <input type="hidden" class="disclaimer_input" name="disclaimer_text" value=""> 
                    <!----<div class="checkbox receive_checkbox">
                        <label>
                            <input class="rcv_email" name="disclaimer" type="checkbox" required="">
                    		<small>
                    			I understand it is a site that provides
                    			&nbsp;<input type="text" placeholder="......................................................" class="disclaimer_input" name="disclaimer_text"> &nbsp; it is up to me to do the work.
                    		</small>
                        </label>
                    </div>-->
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-warning pull-right saveReg" value="Pay">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts-footer')
    <script>
    </script>
@endpush
