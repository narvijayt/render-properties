@extends('layouts.app')

@section('title', 'Register')
@section('meta')
 @php
        $description = 'Register for Render'
    @endphp
    {{ meta('description', $description) }}
    {{ meta('keywords', 'Platinium Membership, Claim your Zip Code, Content Marketing, Blogs & Podcast, SEM, Geo-fencing, Purchase Lending Tree Leads' ) }}
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
        Platinum Membership
    @endcomponent
     <div class="container">
        <div class="row">
            <?php 
                $req = Request::segment(2);
                if(isset($req) && $req != '') {?>
                <div class="alert alert-info">
                          It's time to take your business to the next level. Upgrade your profile with Platinium Membership and claim your Zip Code.
                          </div>
               <?php  } ?>
          	@if (Session::has('message'))
				<p class="alert alert-danger">
					{{ Session::get('message') }}
				</p>
			@endif
			<div class="col-md-6">
			    <div class="img-group clearfix">
			         <div class="pull-left" style="width:150px;">
			             @include('partials.svg.rbc-logo-light-background')
                    </div>
                    <div class="pull-right">
                        <img src="{{asset('img/lendingtree-logo.png')}}" class="img-responsive">
			        </div>
			    </div>
			    
			    <div class="membership_info">
			    <h3>MEMBERS ONLY</h3>
                <h4 style="color:#000;">EXCLUSIVE OFFER!</h4>
                <p>Existing members get the first shot to upgrade and claim their zip code!</p>
                
                <h4 style="color:#000;">The new Platinum Membership will combine:</h4>
                <ul class="check_list">
                    <li>SEO</li>
                    <li>Content Marketing</li>
                    <li>Blogs & Podcast</li>
                    <li>Educational Videos & Resources</li>
                    <li>SEM</li>
                    <li>Social Media Marketing</li>
                    <li>Geo-fencing</li>
                    <li>Ability To Purchase Lending Tree Leads</li>
                </ul>
               
                <h4 style="color:#000;">To provide our platinum members with:</h4>
                <ul class="check_list">
                    <li>More Traffic</li>
                    <li>More Conversions</li>
                    <li>More Followers</li>
                    <li>More Realtors</li>
                    <li>More Visibility</li>
                    <li>More Business</li>
                </ul>
                </div>
			</div>
            <div class="col-md-6">
              <div class="billing-info" style="padding-top:20px;">
              <form action="{{ url('/user-registration') }}" method="post" id="payment-form">
					<input type="hidden" name="user_id" value="{{$user_id}}" /> 
                    <div class="col-md-6 mb-2">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" class="form-control" name="first_name" value="{{ $first_name }}" required="" aria-required="true" />
					</div>
                    <div class="col-md-6 mb-2">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" class="form-control" name="last_name" value="{{ $last_name }}" required="" aria-required="true" />
					</div>
                    <div class="clearfix"></div>
                    <div class="col-md-6 mb-2">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" name="email" value="{{ $email }}" required="" aria-required="true" />
					</div>
                    <div class="col-md-6 mb-2">
                        <label for="company">Company</label>
                        <input type="text" id="company" class="form-control" name="custom" value="{{ $firm_name }}"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6 mb-2">
                        <label for="address1">Billing Address1</label>
                        <input type="text" id="address1" class="form-control" name="address" placeholder="Billing Address 1" required="" aria-required="true"/>
					</div>
                    <div class="col-md-6 mb-2">
                        <label for="address2">Billing Address2</label>
                        <input type="text" id="address2" class="form-control" name="address2" placeholder="Billing Address 2"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4 mb-2">
                        <label for="billing_locality">City</label>
                        <input type="text" id="billing_locality" class="form-control" placeholder="City" name="city" value="{{$city}}" required="" aria-required="true"/>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="billing_region">State</label>
                        <input type="text" id="billing_region" class="form-control" name="state" placeholder="State" value="{{ $state }}" required="" aria-required="true"/>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="billing_postal_code">Zip</label>
                        <input type="text" id="billing_postal_code" class="form-control" name="zip" placeholder="Postal Code" value="{{ $zip }}"  required="" aria-required="true"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 mb-2">
                        <label>Subscription</label>
                            <select name="amount" id="amount" class="form-control">
                                <option value="99.00">Monthly - $99.00 per month</option>
                                <option value="995.00">Yearly - $995.00 per year (Save 16% paying annual)</option>
                            </select>
                    </div>
                    <div class="clearfix"></div>
					<div class="col-md-12">
					    <p class="alert alert-warning alert-sm" style="font-size: 11px;">Your information is securely stored on Authorize.net using 256-bit bank grade encryption. Render does not store credit card information on their servers.
					</p></div>
					<div class="col-md-6 mb-2">
						<label>Card Number</label>
						<input type="number" name="card_num" id="card_num" class="form-control" placeholder="Credit/Debit Card Number" autocomplete="off" required="" aria-required="true">
					</div>
					<div class="col-md-6 mb-2">
						<label>Card Expiration Month</label>
						<input type="text" name="exp_month" maxlength="2" class="form-control" id="card-expiry-month" placeholder="MM" required="" aria-required="true">
					</div>
					<div class="col-md-6 mb-2">
						<label>Card Expiration Year</label>
						<input type="text" name="exp_year" maxlength="4" class="form-control" id="card-expiry-year" placeholder="YYYY" required="" aria-required="true">
					</div>
					<div class="col-md-6 mb-2">
						<label>CVC Code</label>
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
                    <div class="col-md-12 mb-2">
                        <div class="form-group">
                            <input type="submit" class="btn btn-warning pull-right saveReg" value="Pay">
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@push('scripts-footer')
    <script>
    </script>
@endpush