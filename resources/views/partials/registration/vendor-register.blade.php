@inject('states', 'App\Http\Utilities\Geo\USStates')

<div class="vendor-reg-box">
   <div class="box-title-box text-center">
	    <h1 class="box-title line-center family-mont">Vendor Registration</h1>
         <p>Fill out our simple registration form to get started.</p>
	 </div>
<div class="row">		
	<div class="col-md-6 form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
		<input id="fname" type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required>
			
		@if ($errors->has('first_name'))
			<span class="help-block">
			<strong>{{ $errors->first('first_name') }}</strong>
		</span>
		@endif
		
	</div>
	<div class="col-md-6 pl-md-0 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
		<input id="lname" type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
		  @if ($errors->has('last_name'))			 
			<span class="help-block">
			  <strong>{{ $errors->first('last_name') }}</strong>
		  </span>
		@endif
		
	</div>
</div>

<div class="row">
			<div class="col-md-6 form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
				<input id="cname" type="text" class="form-control" name="company_name" placeholder="Company Name" value="{{ old('company_name') }}" required>
					@if ($errors->has('company_name'))
					<span class="help-block">
						<strong>{{ $errors->first('company_name') }}</strong>
					</span>
				@endif
			</div>

			<div class="col-md-6 pl-md-0 form-group{{ $errors->has('phone_no') ? ' has-error' : '' }}">
				<input id="phone_vendor_no" type="text" class="form-control" name="phone_no" placeholder="Phone Number" value="{{ old('phone_no') }}" required>
					<p id="phone-vendor-error" class="error"></p>
					@if ($errors->has('phone_number'))
							<span class="help-block">
								<strong>{{ $errors->first('phone_number') }}</strong>
							</span>
						@endif
			</div>
			
			
			</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	<input id="emailadd" type="text" class="form-control" name="email" placeholder="Enter Email Address" value="{{ old('email') }}" required>
	<p id="email_vendor_error" class="error"></p>
	@if ($errors->has('email'))
		<span class="help-block">
			<strong>{{ $errors->first('email') }}</strong>
		</span>
	@endif
</div>


<div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
	<input id="website" type="text" class="form-control" name="website" placeholder="Enter Website" value="{{ old('website') }}">
		@if ($errors->has('website'))
		<span class="help-block">
			<strong>{{ $errors->first('website') }}</strong>
		</span>
	@endif
</div>


<div class="form-group{{ $errors->has('vendor_coverage_units') ? ' has-error' : '' }}">
	<textarea rows="2" cols="20"class="form-control"  name="vendor_coverage_units" placeholder="Do you cover a City, County, State or the entire USA? " required></textarea>
@if ($errors->has('vendor_coverage_units'))
				<span class="help-block">
                    <strong>{{ $errors->first('vendor_coverage_units') }}</strong>
                </span>
			@endif
</div>
<link rel="stylesheet" type="text/css" href="{{ asset('multicss/example-styles.css')}}">
<div class="form-group">
What Industry are you in?  
<select name="select_category[]" class="form-control {{ $errors->has('select_category[]') ? ' has-error' : '' }}" multiple id="langOpt" required>
    @foreach($allcat as $categoryVendor)
     <option value="{{$categoryVendor->id}}">{{$categoryVendor->name}}</option>
    @endforeach
</select>
@if ($errors->has('select_category[]'))
		<span class="help-block">
			<strong>{{ $errors->first('select_category[]') }}</strong>
		</span>
	@endif
</div>
<div class="form-group{{ $errors->has('other_description') ? ' has-error' : '' }}" style="display:none;" id="otherDesc">
		<input id="other_description" type="text" class="form-control" name="other_description" placeholder="Other Industry Description" value="{{ old('other_description') }}" required>
@if ($errors->has('other_description'))
				<span class="help-block">
                    <strong>{{ $errors->first('other_description') }}</strong>
                </span>
			@endif
</div>
<div class="form-group{{ $errors->has('services') ? ' has-error' : '' }}">
	<textarea rows="2" cols="3"class="form-control"  name="services" placeholder="What services do you offer? " required></textarea>
</div>
<div class="form-group">
	<textarea rows="2" cols="20"class="form-control"  name="short_description" placeholder="Enter short Description"></textarea>

</div>

<div class="row">

			<div class="col-md-5 form-group{{ $errors->has('state') ? ' has-error' : '' }}">
				<select id="state" class="form-control" name="state" required>
					<option value="">Select State</option>
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

			<div class="col-md-4 pl-md-0  form-group">
				  <input class="form-control" type="text" name="city" id="newcity" value="" placeholder="Enter City">
			</div>

			<div class="col-md-3 pl-md-0 form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
				<input id="zip" type="text" class="form-control" name="zip" placeholder="Zip" value="{{ old('zip') }}" data-bv-zipcode-country="true" required >
			</div>
			
			
			<div class="form-group" id="another-city">
				<input type="hidden" name="anotherCity" placeholder="Add another city"  class="form-control" />
			</div>
			
			</div>



<div class="form-group{{ $errors->has('billing_address_1') ? ' has-error' : '' }}">
	<input id="billing_address_1" type="text" class="form-control" name="billing_address_1" placeholder="Address 1" value="{{ old('billing_address_1') }}" data-bv-billing_address_1="true" required >
</div>

<div class="form-group{{ $errors->has('billing_address_2') ? ' has-error' : '' }}">
	<input id="billing_address_2" type="text" class="form-control" name="billing_address_2" placeholder="Address 2" value="{{ old('billing_address_2') }}" data-bv-billing_address_2="true" >
</div>

<div class="row">
				<div class="col-md-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<input id="password" type="password" class="form-control" name="password" placeholder="Password" value="" required>
					@if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>
		
<div class="col-md-6 pl-md-0 form-group{{ $errors->has('cpassword') ? ' has-error' : '' }}">
	<input id="cpassword" type="password" class="form-control" name="cpassword" placeholder="Confirm Password" value="" required>
</div>
</div>
<div class="form-group">
	    <label>Upload Your Advertisement Banner</label>
			<div class="full editp">
				<div class="form-group">
						<div class="checkbox">
							<a href="javascript:uploadBannerImage()" style="text-decoration: none;" class="btn btn-warning">
							<i class="fa fa-edit"></i> Browse File </a>&nbsp;&nbsp;
					</div>
					</div>
					<div id="image">
						<img width="20%" height="20%" id="preview_image" src="{{asset('attach-1.png')}}" style="display:none;" />
						<i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute;left: 40%;top: 40%;display: none"></i>
					</div>
					<input type="file" id="file" style="display: none" />
				<input type="hidden" name="file_name" id="file_name" />
			</div>
	</div>
	<input type="text" name="honey_pot" value="" style="display:none;">
<div class="checkbox receive_checkbox">
	<label>
	      <input type="hidden" name="agree" value="f" />
          <input class="rcv_email" type="checkbox" name="agree" value="t">
       	<small>
		May our vendors contact you in regards to this program?
		</small>
		@if ($errors->has('agree'))
						<span class="help-block">
							<strong>{{ $errors->first('agree') }}</strong>
						</span>
					@endif
	</label>
</div>
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
	<button type="submit" class="btn btn-warning btn-block btn-lg mt-0" id='registerVendor'>REGISTER & PAY</button>
</div>
</div>
<script type="text/javascript" src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.multi-select.js')}}"></script>
<script type="text/javascript">
    $('#langOpt').multiSelect();
    $('#langOpt').on('change', function(){
    var selected = $(this).find("option:selected"); 
        var arrSelected = [];
        selected.each((idx, val) => {
            arrSelected.push(val.value);
        });
    if ($.inArray('19', arrSelected) >= 0)
    {
        $('#otherDesc').css('display','block');
    }else{
        $('#otherDesc').css('display','none');
        $('#other_description').val('');
    }
    });
 </script>