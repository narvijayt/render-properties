@inject('states', 'App\Http\Utilities\Geo\USStates')

{{ csrf_field() }}
@if((isset($user) && isset($user->provider_id) && isset($user) && isset($user->provider)))
	<input name="provider" type="hidden" value="{{$user->provider}}">
	<input name="provider_id" type="hidden" value="{{$user->provider_id}}">
@endif
<input type="text" name="honey_pot" value="" style="display:none;">
 @if($_GET['type'] == 'lender')
 {{--
<div class="row util__collapse Availability-form">
    <h4>Check availability of zip code:</h4>

    <div class="col-md-8 form-group{{ $errors->has('postal_code_service') ? ' has-error' : '' }}">
    	<input id="postal_code_service" type="text" class="form-control" name="postal_code_service" placeholder="Please enter the zip code" value="{{ old('postal_code_service') }}" required autocomplete="off">
    	<p id="postal-error" class="error"></p>
    	<p class="notify-success"></p>
	</div>
	<div class="col-md-4 form-group">
    	<buttton id="postal_code_service_btn" class="btn btn-primary">Check Availability</buttton>
    	<div id="loading-imgs" style="display: none;position: absolute;z-index: 9;top: 51%;left: 62%;transform: translate(-50%, -50%);width: 80%;">
        	<img src="{{asset('img/profile-loader.gif')}}" >
        </div>
	</div>
	<div class="notify-box hidden">
		<p id="notify-txt"></p>
		<button id="notify-btn" type="button" class="btn btn-success notify-btn">Notify Me</button>
		<div class="suggested-zip" style="display:none"></div>
	</div>
	@if ($errors->has('postal_code_service'))
		<span class="help-block">
			<strong>{{ $errors->first('postal_code_service') }}</strong>
		</span>
	@endif
</div>
--}}
@endif

@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
@endif

<h4 class="text-center"> Fill out our simple registration form to get started: </h4>

				<div class="row util__collapse">
					<div class="col-md-6 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
						<input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ old('first_name', isset($user) && isset($user->first_name) ? $user->first_name : '' ) }}" required autofocus>
					</div>
					<div class="col-md-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
						<input id="last_name" type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name', isset($user) && isset($user->last_name) ? $user->last_name : '' ) }}" required >
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
					<input id="firm_name" type="text" class="form-control" name="firm_name" placeholder="Company Name" value="{{ old('firm_name') }}" >
					@if ($errors->has('firm_name'))
						<span class="help-block">
							<strong>{{ $errors->first('firm_name') }}</strong>
						</span>
					@endif
			</div>
			
			<div style="display:none;" class="form-group{{ $errors->has('user_type') ? ' has-error' : '' }}">
				<label class="control-label">Register as:</label>
				<div class="row">
					<div class="col-xs-6">
						<div class="radio">
							<label for="user_type--realtor">
								<input type="radio" class="radio registration-info-switcher" data-info-switch="realtor" name="user_type" id="user_type--realtor" @if (old('user_type') === 'realtor' || $registerType === 'realtor') checked="checked" @endif value="realtor">
								Realtor
							</label>
						</div>

						<div class="radio">
							<label for="user_type--lender">
								<input type="radio" class="radio registration-info-switcher" data-info-switch="lender" id="user_type--lender" @if (old('user_type') === 'broker' || $registerType === 'lender') checked="checked" @endif name="user_type" value="broker">
								Lender
							</label>
						</div>
					</div>
				</div>
				@if ($errors->has('user_type'))
					<span class="help-block">
						<strong>{{ $errors->first('user_type') }}</strong>
					</span>
				@endif
			</div>

	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		<input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', isset($user) && isset($user->email) ? $user->email : '' ) }}" required >
		<p id="email_error" class="error"></p>
		@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
		@endif
	</div>
	
	
  <div class="row util__collapse">
  
    @if($_GET['type'] == 'realtor' || $_GET['type'] == 'lender')
	<div class="col-xs-12">
	@else
	<div class="col-xs-8">
	@endif
		<div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
			<input id="phone_number" type="text" class="form-control" name="phone_number" placeholder="Phone Number" data-politespace {{--data-politespace-us-telephone--}} data-politespace-strip="[^\d]*" data-politespace-grouplength="3,3,4" data-politespace-delimiter="-" value="{{ old('phone_number', isset($user) && isset($user->phone_number) ? $user->phone_number : '' ) }}" required >
			<p id="phone-error" class="error"></p>
			@if ($errors->has('phone_number'))
				<span class="help-block">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
			@endif
		</div>
	</div>
	 @if($_GET['type'] == 'realtor' || $_GET['type'] == 'lender')
	<input id="phone_ext" type="hidden" class="form-control" name="phone_ext" placeholder="Extension" value="">
	@else
	<div class="col-xs-4">
		<div class="form-group{{ $errors->has('phone_ext') ? ' has-error' : '' }}">
			<input id="phone_ext" type="text" class="form-control" name="phone_ext" placeholder="Extension" value="{{ old('phone_ext', isset($user) && isset($user->phone_ext) ? $user->phone_ext : '' ) }}" >
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
	<input id="website" type="text" class="form-control" name="website" placeholder="Website URL" value="{{ old('website', isset($user) && isset($user->website) ? $user->website : '' ) }}" >
	@if ($errors->has('website'))
		<span class="help-block">
			<strong>{{ $errors->first('website') }}</strong>
		</span>
	@endif
</div>

<div class="row">
		<div class="col-md-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}  pr-0">
			<input id="password" type="password" class="form-control" name="password" placeholder="Password" required >
			@if ($errors->has('password'))
				<span class="help-block">
					<strong>{{ $errors->first('password') }}</strong>
				</span>
			@endif
		</div>
		<div class="col-md-6 form-group">
			<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required >
		</div>
		
	</div>

    @if($_GET['type'] == 'realtor')
        {{--
        <div class="form-group{{ $errors->has('specialties') ? ' has-error' : '' }}">
            <textarea id="specialties" class="form-control" name="specialties" placeholder="Do you work with commercial buyers?" >{{ old('specialties') }}</textarea>
            
            @if ($errors->has('specialties'))
        		<span class="help-block">
                    <strong>{{ $errors->first('specialties') }}</strong>
                </span>
        	@endif
        </div>
        --}}
    @else
        <div class="form-group{{ $errors->has('specialties') ? ' has-error' : '' }}">
    		<textarea id="specialties" class="form-control" name="specialties" placeholder="Specialties" required >{{ old('specialties') }}</textarea>		
    		@if ($errors->has('specialties'))
        		<span class="help-block">
                    <strong>{{ $errors->first('specialties') }}</strong>
                </span>
        	@endif
        </div>
    @endif
	
<div class="form-group{{ $errors->has('license') ? ' has-error' : '' }}">
	<input id="license" type="text" class="form-control" name="license" placeholder="License#" value="{{ old('license', isset($user) && isset($user->license) ? $user->license : '' ) }}" >
	<p id="license_error" class="error"></p>
	@if ($errors->has('license'))
		<span class="help-block">
            <strong>{{ $errors->first('license') }}</strong>
        </span>
	@endif
</div>
@if($_GET['type'] != 'realtor' && $_GET['type'] != 'lender')
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
@if($_GET['type'] != 'lender')
<input type="hidden" name="units_closed_monthly" value="">
<input type="hidden" name="volume_closed_monthly" value="">
@endif
@if($_GET['type'] != 'lender')
{{--
<div class="form-group{{ $errors->has('volume_closed_monthly') ? ' has-error' : '' }}">
	<select class="form-control" name="volume_closed_monthly" id="volume_closed_monthly">
		<option value="">Buyer Side Transactions closed in the last 12 months</option>
		<option value="0-5">0-5 Transactions</option>
		<option value="6-12">6-12 Transactions</option>
		<option value="12-20">12-20 Transactions</option>
		<option value="20+">20+ Transactions</option>
	</select>
	@if ($errors->has('volume_closed_monthly'))
		<span class="help-block">
			<strong>{{ $errors->first('volume_closed_monthly') }}</strong>
		</span>
	@endif
</div>
--}} 

<div class="form-group{{ $errors->has('how_long_realtor') ? ' has-error' : '' }}">
	<input id="how_long_realtor" type="text" class="form-control" name="how_long_realtor" placeholder="How long have you been a Realtor?" value="{{ old('how_long_realtor') ? old('how_long_realtor') : '' }}" required />
</div>
@endif
<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
	<select id="state" class="form-control" name="state" required>
		<option value="">Choose a state</option>
		@foreach($states::all() as $abbr => $stateName)
			<option value="{{ $abbr }}" {{ collect(old('state'))->contains($abbr) ? 'selected' : '' }}>{{ $stateName }}</option>
		@endforeach
	</select>
	@if ($errors->has('state'))
		<span class="help-block">
			<strong>{{ $errors->first('state') }}</strong>
		</span>
	@endif
</div>
<!------With city require vaildation -->
<!----<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
	<select class="form-control" name="city" id="city" required>
		<option value="">Select City</option>

	</select>
	@if ($errors->has('city'))
		<span class="help-block">
			<strong>{{ $errors->first('city') }}</strong>
		</span>
	@endif
</div>-->

<div class="row">

	<div class="col-md-6 pr-0 form-group col-xs-6">
		<!---city drop down ------------->
		<!----<select class="form-control" name="city" id="city">
			<option value="">Select City</option>
		</select>-->
		  <input class="form-control" type="text" name="city" id="newcity" value="" placeholder="Enter City">
	</div>
	<div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }} col-md-6 col-xs-6">
		<input id="zip" type="text" class="form-control" name="zip" placeholder="Zip Code" value="{{ old('zip') }}" required >
	</div>
	<div class="form-group" id="another-city">
		<input type="hidden" name="anotherCity" placeholder="Add another city"  class="form-control" />
	</div>

      </div>


		@if($_GET['type'] == 'realtor')
	<!---<div class="well">
       <div class="row">
          <div class="col-md-8 pr-0">  
		<div class="receive_checkbox">
			   Would you be interested in providing video or text content that Render would use to promote your profile?
			 
			     </div>
			     </div>
				 
				 <div class="col-md-4">
				 
				    <div class="radio fancy_radio">
						
							   <label><input type="radio" name="provide_content" value="t" />  <span>Yes</span></label>
						   
								 <label><input class="rcv_email" type="radio" name="provide_content" value="f"> <span>No </span></label>
								   </div>
			           </div>
			  
				</div>
				</div>-->
				<input class="rcv_email" type="hidden"  name="provide_content"  value="f">
								
								@else
								 <input class="rcv_email" type="hidden"  name="provide_content"  value="f">
							
                    
	      @endif
   


        
			@if($_GET['type'] != 'realtor')
			                
	
			       <div class="checkbox fancy_checkbox">
				     <label>
					   <input class="rcv_email" type="checkbox" name="agree" value="t"><span> May our vendors contact you in regards to this program? </span>
				        <input type="hidden" name="agree" value="f" /> 
				       </label>
			       </div>			  
                    
			
			@else
				 <input type="hidden" name="agree" value="f" /> 
		<!---	 <div class="well">
             <div class="row">
			      <div class="col-md-8">
				     Is it ok for our platinum members to contact you about the program and about you becoming a gold standard agent?
				   </div>
				   <div class="col-md-4">
					<div class="radio fancy_radio">						
						<label><input type="radio" name="agree" value="t" /><span>Yes</span></label>
						<label><input class="rcv_email" type="radio" id="agree_term" name="agree" value="f"><span>No</span></label>
					</div>
					</div>
			  </div>
            </div>-->
			
			@endif


@if($_GET['type'] == 'realtor')
	{{--<div class="form-group">
    	<div class="radio fancy_radio">
			<span>Are you interested in working with free buyer leads as these can help expand your network and potentially increase your business opportunities?</span>
    		<div class="input-radio-group">
        		<label class="radio-inline">
        		    <input id="rbc_free_marketing_yes" class="form-control" type="radio" name="rbc_free_marketing" value="Yes" @if (old('rbc_free_marketing') && old('rbc_free_marketing') == "Yes") checked="checked" @endif required /> <span>Yes</span>
        		</label>
        		<label class="radio-inline">
        		    <input id="rbc_free_marketing_no" class="form-control" type="radio" name="rbc_free_marketing" value="No" @if (old('rbc_free_marketing') && old('rbc_free_marketing') == "No") checked="checked" @endif required /><span>No</span>
        		</label>
    		</div>
    	</div>
    </div>
    

	<div class="form-group">
    	<div class="radio fancy_radio">
    		<span>Are you interested in working with {!! get_application_name() !!} home buyer leads with zero upfront fees and paying a 17% referral at closing for buyer leads?</span>
    		<div class="input-radio-group">
        		<label class="radio-inline">
        		    <input id="referral_fee_acknowledged_yes" class="form-control" type="radio" name="referral_fee_acknowledged" value="Yes" @if (old('referral_fee_acknowledged') && old('referral_fee_acknowledged') == "Yes") checked="checked" @endif required /> <span>Yes</span>
        		</label>
        		<label class="radio-inline">
        		    <input id="referral_fee_acknowledged_no" class="form-control" type="radio" name="referral_fee_acknowledged" value="No" @if (old('referral_fee_acknowledged') && old('referral_fee_acknowledged') == "No") checked="checked" @endif required /><span>No</span>
        		</label>
    		</div>
    	</div>
    </div>

    
    <div class="form-group">
    	<div class="radio fancy_radio">
    		<span>Would you like to find a loan officer to co-market with Zillow, Realtor.com or other lead sources with you?</span> 
    		<div class="input-radio-group">
        		<label class="radio-inline">
        		    <input id="co_market_yes" class="form-control" type="radio" name="co_market" value="Yes" @if (old('co_market') && old('co_market') == "Yes") checked="checked" @endif required /> <span>Yes</span>
        		</label>
        		<label class="radio-inline">
        		    <input id="co_market_no" class="form-control" type="radio" name="co_market" value="No" @if (old('co_market') && old('co_market') == "No") checked="checked" @endif required /><span>No</span>
        		</label>
    		</div>
    	</div>
    </div>
    
    
    <div class="form-group">
    	<div class="radio fancy_radio">
    		<span>{!! get_application_name() !!} referral fees are low because {!! get_application_name() !!} matches our loan officer members with Realtor members. Can our loan officers contact you to see if you would be a match to work together?</span> 
    		<div class="input-radio-group">
        		<label class="radio-inline">
        		    <input id="contact_me_for_match_yes" class="form-control" type="radio" name="contact_me_for_match" value="Yes" @if (old('contact_me_for_match') && old('contact_me_for_match') == "Yes") checked="checked" @endif required /> <span>Yes</span>
        		</label>
        		<label class="radio-inline">
        		    <input id="contact_me_for_match_no" class="form-control" type="radio" name="contact_me_for_match" value="No" @if (old('contact_me_for_match') && old('contact_me_for_match') == "No") checked="checked" @endif required /><span>No</span>
        		</label>
    		</div>
    	</div>
    </div>
	--}}
    
    <div class="form-group">
    	<div class="radio fancy_radio">
		{{--<label>
    		    <input id="open_to_lender_relations_yes" class="form-control" type="checkbox" name="open_to_lender_relations" value="yes" @if (old('open_to_lender_relations')) checked="checked" @endif required >
    		    <span>Are you open to new lender relationships that will benefit your business?</span>
    		</label> 
    		--}}

			<span>Are you open to new lender relationships that will benefit your business?</span>
        		<div class="input-radio-group">
            		<label class="radio-inline">
            		    <input id="open_to_lender_relations_yes" class="form-control" type="radio" name="open_to_lender_relations" value="Yes" @if (old('open_to_lender_relations') && old('open_to_lender_relations') == "Yes") checked="checked" @endif required /> <span>Yes</span>
            		</label>
            		<label class="radio-inline">
            		    <input id="open_to_lender_relations_no" class="form-control" type="radio" name="open_to_lender_relations" value="No" @if (old('open_to_lender_relations') && old('open_to_lender_relations') == "No") checked="checked" @endif required /><span>No</span>
            		</label>
        		</div>
    		
    	</div>
    </div>
    
    <div class="form-group">
    	<div class="radio fancy_radio">
    		<span>I understand that I have to match with a {!! get_application_name() !!} Loan Officer to be part of the home buyer leads program.</span> 
    		<div class="input-radio-group">
        		<label class="radio-inline">
        		    <input id="lo_matching_acknowledged_yes" class="form-control" type="radio" name="lo_matching_acknowledged" value="Yes" @if (old('lo_matching_acknowledged') && old('lo_matching_acknowledged') == "Yes") checked="checked" @endif required /> <span>Yes</span>
        		</label>
        		<label class="radio-inline">
        		    <input id="lo_matching_acknowledged_no" class="form-control" type="radio" name="lo_matching_acknowledged" value="No" @if (old('lo_matching_acknowledged') && old('lo_matching_acknowledged') == "No") checked="checked" @endif required /><span>No</span>
        		</label>
    		</div>
    	</div>
    </div>
    
    {{--
    <div class="form-group">
    	<div class="checkbox fancy_checkbox">
    		<label>
    		    <input id="enable_emails" class="form-control" type="checkbox" name="enable_emails" value="yes" @if (old('enable_emails')) checked="checked" @endif >
    		    <span>Loan Officers and Vendors can contact me about possible beneficial business relationships.</span> 
    		</label>
    	</div>
    </div>
	--}}
@else

<div class="form-group">
	<div class="checkbox fancy_checkbox">
		<label>
		    <input id="receive_email" class="rcv_email" type="checkbox" name="receive_email" value="yes" @if ((!old('receive_email') && !$errors->any()) || old('receive_email')) checked="checked" @endif >
		    <span>I would like to receive a weekly email containing potential business opportunities with other realtors & lenders matching my criteria</span> 
		</label>
	</div>
</div>

@endif

{{--
<div class="form-group">
	<div class="checkbox fancy_checkbox">
		<label>
		    <input id="receive_email" class="rcv_email" type="checkbox" name="receive_email" value="yes" @if ((!old('receive_email') && !$errors->any()) || old('receive_email')) checked="checked" @endif >
		    <span>I would like to receive a weekly email containing potential business opportunities with other realtors & lenders matching my criteria</span> 
		</label>
	</div>
</div>
--}} 

	<script src="https://www.google.com/recaptcha/api.js"></script>
	<div class="form-group row">
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
               
<div class="form-group">
	<button type="submit" class="btn btn-warning btn-block" id='reg-btn'>
		@if(!empty($_GET))
			@if(isset($_GET) && $_GET['type'] == 'realtor')
				Register
			@elseif($_GET['type'] == 'lender')
				Next
			@else
				Register
			@endif
		@else
			Register
		@endif
	</button>
</div>
