@inject('states', 'App\Http\Utilities\Geo\USStates')

{{ csrf_field() }}
@if((isset($user) && isset($user->provider_id) && isset($user) && isset($user->provider)))
	<input name="provider" type="hidden" value="{{$user->provider}}">
	<input name="provider_id" type="hidden" value="{{$user->provider_id}}">
@endif
	<input type="text" name="honey_pot" value="" style="display:none;">

@if(session()->has('message'))
	<div class="alert alert-success">
		{{ session()->get('message') }}
	</div>
@endif
@if(session('error'))
	<div class="alert alert-danger">{{session('error')}}</div>
@endif

<h2 class="text-center mt-0 mb-1"> GET STARTED </h2>

<div class="row util__collapse d-grid-group">
    <div class="col-md-6 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
        <input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ old('first_name', isset($user) && isset($user->first_name) ? $user->first_name : '' ) }}" required autofocus>
    </div>
    <div class="col-md-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
        <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name', isset($user) && isset($user->last_name) ? $user->last_name : '' ) }}" required>
    </div>
    @if ($errors->has('first_name') || $errors->has('last_name') || $errors->has('title'))
    <span class="help-block">
        @if ($errors->has('first_name'))
        	<strong>{{ $errors->first('first_name') }}</strong>
        @endif
        @if ($errors->has('last_name'))
        	<strong>{{ $errors->first('last_name') }}</strong>
        @endif
        @if ($errors->has('title'))
        	<strong>{{ $errors->first('title') }}</strong>
        @endif
    </span>
    @endif
</div>
<div class="form-group{{ $errors->has('firm_name') ? ' has-error' : '' }}">
    <input id="firm_name" type="text" class="form-control" name="firm_name" placeholder="Company Name" value="{{ old('firm_name') }}">
    @if ($errors->has('firm_name'))
    <span class="help-block">
        <strong>{{ $errors->first('firm_name') }}</strong>
    </span>
    @endif
</div>


<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', isset($user) && isset($user->email) ? $user->email : '' ) }}" required>
    <p id="email_error" class="error"></p>
    @if ($errors->has('email'))
    <span class="help-block">
        <strong>{{ $errors->first('email') }}</strong>
    </span>
    @endif
</div>

<hr class="style1">

<div class="row util__collapse">
    @if($registerType == 'realtor' || $registerType == 'lender')
    	<div class="col-xs-12">
    @else
        <div class="col-xs-8">
    @endif
	<div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
		<input id="phone_number" type="text" class="form-control" name="phone_number" placeholder="Phone Number" data-politespace {{--data-politespace-us-telephone--}} data-politespace-strip="[^\d]*" data-politespace-grouplength="3,3,4" data-politespace-delimiter="-" value="{{ old('phone_number', isset($user) && isset($user->phone_number) ? $user->phone_number : '' ) }}" required>
		<p id="phone-error" class="error"></p>
		@if ($errors->has('phone_number'))
		<span class="help-block">
			<strong>{{ $errors->first('phone_number') }}</strong>
		</span>
		@endif
	</div>
</div>
@if($registerType == 'realtor' || $registerType == 'lender')
	<input id="phone_ext" type="hidden" class="form-control" name="phone_ext" placeholder="Extension" value="">
@else
	<div class="col-xs-4">
		<div class="form-group{{ $errors->has('phone_ext') ? ' has-error' : '' }}">
			<input id="phone_ext" type="text" class="form-control" name="phone_ext" placeholder="Extension" value="{{ old('phone_ext', isset($user) && isset($user->phone_ext) ? $user->phone_ext : '' ) }}">
			@if ($errors->has('phone_ext'))
			<span class="help-block">
				<strong>{{ $errors->first('phone_ext') }}</strong>
			</span>
			@endif
		</div>
	</div>
@endif
</div>
<div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
	<input id="website" type="text" class="form-control" name="website" placeholder="Website URL" value="{{ old('website', isset($user) && isset($user->website) ? $user->website : '' ) }}">
	@if ($errors->has('website'))
	<span class="help-block">
		<strong>{{ $errors->first('website') }}</strong>
	</span>
	@endif
</div>

<div class="form-group{{ $errors->has('license') ? ' has-error' : '' }}">
	<input id="license" type="text" class="form-control" name="license" placeholder="License#" value="{{ old('license', isset($user) && isset($user->license) ? $user->license : '' ) }}">
	<p id="license_error" class="error"></p>
	@if ($errors->has('license'))
	<span class="help-block">
		<strong>{{ $errors->first('license') }}</strong>
	</span>
	@endif
</div>

<hr class="style1">

<div class="row d-grid-group util__collapse">
	<div class="col-md-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}  pr-0">
		<input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
		@if ($errors->has('password'))
		<span class="help-block">
			<strong>{{ $errors->first('password') }}</strong>
		</span>
		@endif
	</div>
	<div class="col-md-6 form-group">
		<input id="password-confirm" type="password" class="form-control" name="password_confirmation"
			placeholder="Confirm Password" required>
	</div>
</div>

<hr class="style1">

@if($registerType != 'realtor' && $registerType != 'lender')
	<div class="form-group{{ $errors->has('units_closed_monthly') ? ' has-error' : '' }}">
		<select class="form-control" name="units_closed_monthly" id="units_closed_monthly">
			<option value="">Number of Units Closed Monthly</option>
			<option value="0-5">0 - 5</option>
			<option value="6-10">6 - 10</option>
			<option value="20+">20+</option>
		</select>
		@if ($errors->has('units_closed_monthly'))
		<span class="help-block">
			<strong>{{ $errors->first('units_closed_monthly ') }}</strong>
		</span>
		@endif
	</div>
@endif

@if($registerType != 'lender')
	<input type="hidden" name="units_closed_monthly" value="">
	<input type="hidden" name="volume_closed_monthly" value="">
@endif
@if($registerType != 'lender')
	<div class="form-group{{ $errors->has('how_long_realtor') ? ' has-error' : '' }}">
		<input id="how_long_realtor" type="text" class="form-control" name="how_long_realtor" placeholder="How long have you been a Realtor?" value="{{ old('how_long_realtor') ? old('how_long_realtor') : '' }}" required />
	</div>
@endif

<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
	<select id="state" class="form-control" name="state" required>
		<option value="">Choose a state</option>
		@foreach($states::all() as $abbr => $stateName)
		<option value="{{ $abbr }}" {{ collect(old('state'))->contains($abbr) ? 'selected' : '' }}>{{ $stateName }}
		</option>
		@endforeach
	</select>
	@if ($errors->has('state'))
	<span class="help-block">
		<strong>{{ $errors->first('state') }}</strong>
	</span>
	@endif
</div>

<div class="row d-grid-group util__collapse">
	<div class="col-md-6 pr-0 form-group col-xs-6">
		<input class="form-control" type="text" name="city" id="newcity" value="{{ old('city') }}" placeholder="Enter City">
	</div>
	<div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }} col-md-6 col-xs-6">
		<input id="zip" type="text" class="form-control" name="zip" placeholder="Zip Code" value="{{ old('zip') }}" required>
	</div>
	<div class="form-group" id="another-city">
		<input type="hidden" name="anotherCity" placeholder="Add another city" class="form-control" />
	</div>
</div>
<hr class="style1">

<input class="rcv_email" type="hidden" name="provide_content" value="f">
@if($registerType == 'lender')
	<div class="form-group{{ $errors->has('specialties') ? ' has-error' : '' }}">
		<span>What types of mortgage products do you specialize in, and can you provide examples of recent success stories with these products?</span>
		<textarea id="specialties" class="form-control" name="specialties" required>{{ old('specialties') }}</textarea>
		@if ($errors->has('specialties'))
		<span class="help-block">
			<strong>{{ $errors->first('specialties') }}</strong>
		</span>
		@endif
	</div>
	<div class="form-group{{ $errors->has('stay_updated') ? ' has-error' : '' }}">
		<span>How do you stay updated on changes in the mortgage industry, and what steps do you take to ensure you can offer the best financing solutions to your clients?</span>
		<textarea id="stay_updated" class="form-control" name="stay_updated" required>{{ old('stay_updated') }}</textarea>
		@if ($errors->has('stay_updated'))
		<span class="help-block">
			<strong>{{ $errors->first('stay_updated') }}</strong>
		</span>
		@endif
	</div>
	<div class="form-group{{ $errors->has('handle_challanges') ? ' has-error' : '' }}">
		<span>How do you handle challenging or unique financing situations, such as clients with low credit scores or non-traditional income sources?</span>
		<textarea id="handle_challanges" class="form-control" name="handle_challanges" required>{{ old('handle_challanges') }}</textarea>
		@if ($errors->has('handle_challanges'))
		<span class="help-block">
			<strong>{{ $errors->first('handle_challanges') }}</strong>
		</span>
		@endif
	</div>
	<div class="form-group{{ $errors->has('unique_experties') ? ' has-error' : '' }}">
		<span>What sets you apart from other loan officers in terms of the level of service and expertise you provide to your clients, and how do you ensure a smooth and efficient mortgage application process?</span>
		<textarea id="unique_experties" class="form-control" name="unique_experties" required>{{ old('unique_experties') }}</textarea>
		@if ($errors->has('unique_experties'))
		<span class="help-block">
			<strong>{{ $errors->first('unique_experties') }}</strong>
		</span>
		@endif
	</div>

	@php 
	$partnership_with_realtor = old('partnership_with_realtor');
	@endphp
	<div class="form-group">
		<div class="radio fancy_radio">
			<span>Are you open to forming partnerships with real estate professionals to receive referrals, and can other members of the Render community contact you for collaboration opportunities?</span>
			<div class="input-radio-group">
				<label class="radio-inline">
					<input id="partnership_with_realtor_yes" class="form-control" type="radio" name="partnership_with_realtor" value="yes" @if ($partnership_with_realtor=="yes" ) checked="checked" @endif required /> <span>Yes</span>
				</label>
				<label class="radio-inline">
					<input id="partnership_with_realtor_no" class="form-control" type="radio" name="partnership_with_realtor" value="no" @if ($partnership_with_realtor=="no" ) checked="checked" @endif required /><span>No</span>
				</label>
			</div>
		</div>
	</div>


	{{-- <div class="form-group">
		<div class="checkbox fancy_checkbox">
			<label>
				<input id="receive_email" class="rcv_email" type="checkbox" name="receive_email" value="yes" @if(old('receive_email')) checked="checked" @endif >
				<span>I would like to receive a weekly email containing potential business opportunities with other
					realtors & lenders matching my criteria</span>
			</label>
		</div>
	</div> --}}
	
@endif

@if($registerType == 'realtor')
	<input type="hidden" name="agree" value="f" />
	@php
		$require_financial_solution = old('contact_me_for_match') ? old('require_financial_solution') : '';
		$require_professional_service = old('require_professional_service') ? old('require_professional_service') : '';
		$partnership_with_lender = old('partnership_with_lender') ? old('partnership_with_lender') : '';
		$partnership_with_vendor = old('partnership_with_vendor') ? old('partnership_with_vendor') : '';
		$can_realtor_contact = old('can_realtor_contact') ? old('can_realtor_contact') : '';
	@endphp
	 
	<div class="form-group">
		<div class="radio fancy_radio">
			<span>Are you actively seeking financing solutions for your clients?</span>
			<div class="input-radio-group">
				<label class="radio-inline">
					<input id="require_financial_solution_yes" class="form-control" type="radio" name="require_financial_solution" value="yes" @if ($require_financial_solution=="yes" ) checked="checked" @endif required /> <span>Yes</span>
				</label>
				<label class="radio-inline">
					<input id="require_financial_solution_no" class="form-control" type="radio" name="require_financial_solution" value="no" @if ($require_financial_solution=="no" ) checked="checked" @endif required /><span>No</span>
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="radio fancy_radio">
			<span>Do you require professional services such as photography, home staging, or property inspection for your property listings?</span>
			<div class="input-radio-group">
				<label class="radio-inline">
					<input id="require_professional_service_yes" class="form-control" type="radio" name="require_professional_service" value="yes" @if ($require_professional_service=="yes" ) checked="checked" @endif required /> <span>Yes</span>
				</label>
				<label class="radio-inline">
					<input id="require_professional_service_no" class="form-control" type="radio" name="require_professional_service" value="no" @if ($require_professional_service==no) checked="checked" @endif required /><span>No</span>
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="radio fancy_radio">
			<span>Are you interested in forming partnerships with reputable lenders and vendors in your area to enhance your real estate services?</span>
			<div class="mt-1">Lender</div>
			<div class="input-radio-group">
				<label class="radio-inline">
					<input id="partnership_with_lender_yes" class="form-control" type="radio" name="partnership_with_lender" value="yes" @if ($partnership_with_lender=="yes" ) checked="checked" @endif required /> 
					<span>Yes</span>
				</label>
				<label class="radio-inline">
					<input id="partnership_with_lender_no" class="form-control" type="radio" name="partnership_with_lender" value="no" @if ($partnership_with_lender=="no" ) checked="checked" @endif required /><span>No</span>
				</label>
			</div>

			<div class="mt-1">Vendor</span>
				<div class="input-radio-group">
					<label class="radio-inline">
						<input id="partnership_with_vendor_yes" class="form-control" type="radio" name="partnership_with_vendor" value="yes" @if ($partnership_with_vendor=="yes" ) checked="checked" @endif required /> <span>Yes</span>
					</label>
					<label class="radio-inline">
						<input id="partnership_with_vendor_no" class="form-control" type="radio" name="partnership_with_vendor" value="no" @if ($partnership_with_vendor=="no" ) checked="checked" @endif required /><span>No</span>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="radio fancy_radio">
			<span>Can other Realtors contact you with Referrals?</span>
			<div class="input-radio-group">
				<label class="radio-inline">
					<input id="can_realtor_contact_yes" class="form-control" type="radio" name="can_realtor_contact" value="yes" @if ($can_realtor_contact=="yes" ) checked="checked" @endif required />
					<span>Yes</span>
				</label>
				<label class="radio-inline">
					<input id="can_realtor_contact_no" class="form-control" type="radio" name="can_realtor_contact" value="no" @if ($can_realtor_contact=="no" ) checked="checked" @endif required /><span>No</span>
				</label>
			</div>
		</div>
	</div>
@endif


@if($registerType == 'lender')
<div class="checkbox fancy_checkbox">
	<label>
		<input class="rcv_email" type="checkbox" {{ old("accept_terms") ? "checked" : "" }} name="accept_terms" value="1"><span> I have read and agree to the <a href="{{ route('pub.terms-and-conditions.index')}}" target="_blank">Terms and Conditions</a> </span>
	</label>
	<p>{!! get_application_name() !!} has a 30 day refund policy. If your not happy for any reason please <a href="{{ route('pub.contact.index') }}" target="_blank">contact us</a> for a full refund within 30 days of signing up for a paid membership.</p>
</div>
@endif

<hr class="style1">
@if(env('APP_ENV') != 'local')
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<div class="form-group row recaptcha-row">
		<div class="col-md-6 offset-md-4 recaptcha-row-inner">
			<div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
			<span class="msg-error error"></span>
			@if ($errors->has('g-recaptcha-response'))
				<span class="invalid-feedback" style="display: block;">
					<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
				</span>
			@endif
		</div>
	</div>
@endif

<div class="form-group justify-content-center form-btn-group">
	<button type="submit" class="btn btn-warning btn-yellow" id='reg-btn'>
		@if(!empty($_GET))
		@if(isset($_GET) && $registerType == 'realtor')
		Register
		@elseif($registerType == 'lender')
		Next
		@else
		Register
		@endif
		@else
		Register
		@endif
	</button>
	@if(isset($registerType))
		<input type="hidden" name="user_type" value="{{ ($registerType == 'lender') ? 'broker' : $registerType }}" />
	@endif
</div>