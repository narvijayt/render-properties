@inject('states', 'App\Http\Utilities\Geo\USStates')

<div class="vendor-reg-box vendor-reg-box-01">
    <div class="box-title-box text-center">
        <h2 class="text-center mt-0 mb-1"> GET STARTED </h2>
        {{--<p>Fill out our simple registration form to get started.</p>--}}
    </div>
    <div class="row">
        <div class="col-md-6 form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
            <input id="fname" type="text" class="form-control" name="first_name" placeholder="First Name"
                value="{{ old('first_name') }}" required>

            @if ($errors->has('first_name'))
            <span class="help-block">
                <strong>{{ $errors->first('first_name') }}</strong>
            </span>
            @endif

        </div>
        <div class="col-md-6 pl-md-0 form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
            <input id="lname" type="text" class="form-control" name="last_name" placeholder="Last Name"
                value="{{ old('last_name') }}" required>
            @if ($errors->has('last_name'))
            <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
            @endif

        </div>
    </div>


    <div class="form-group {{ $errors->has('company_name') ? ' has-error' : '' }}">
        <input id="cname" type="text" class="form-control" name="company_name" placeholder="Company Name"
            value="{{ old('company_name') }}" required>
        @if ($errors->has('company_name'))
        <span class="help-block">
            <strong>{{ $errors->first('company_name') }}</strong>
        </span>
        @endif
    </div>

	<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
        <input id="emailadd" type="text" class="form-control" name="email" placeholder="Enter Email Address"
            value="{{ old('email') }}" required>
        <p id="email_vendor_error" class="error"></p>
        @if ($errors->has('email'))
        <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
    </div>

	<hr class="style1">

    <div class="form-group {{ $errors->has('phone_no') ? ' has-error' : '' }}">
        <input id="phone_vendor_no" type="text" class="form-control" name="phone_no" placeholder="Phone Number"
            value="{{ old('phone_no') }}" required>
        <p id="phone-vendor-error" class="error"></p>
        @if ($errors->has('phone_number'))
        <span class="help-block">
            <strong>{{ $errors->first('phone_number') }}</strong>
        </span>
        @endif
    </div>

    
    <div class="form-group {{ $errors->has('website') ? ' has-error' : '' }}">
        <input id="website" type="text" class="form-control" name="website" placeholder="Enter Website"
            value="{{ old('website') }}">
        @if ($errors->has('website'))
        <span class="help-block">
            <strong>{{ $errors->first('website') }}</strong>
        </span>
        @endif
    </div>

	<hr class="style1">
	
	<div class="row">
        <div class="col-md-6 form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" placeholder="Password" value=""
                required>
            @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>

        <div class="col-md-6 pl-md-0 form-group {{ $errors->has('cpassword') ? ' has-error' : '' }}">
            <input id="cpassword" type="password" class="form-control" name="cpassword" placeholder="Confirm Password"
                value="" required>
        </div>
    </div>

	<hr class="style1">

	<div class="row">

        <div class="col-md-12 form-group {{ $errors->has('state') ? ' has-error' : '' }}">
            <select id="state" class="form-control" name="state" required>
                <option value="">Select State</option>
                @foreach($states::all() as $abbr => $stateName)
                <option value="{{ $abbr }}" {{ collect(old('state'))->contains($abbr) ? 'selected' : '' }}>
                    {{ $stateName }}</option>
                @endforeach
            </select>
            @if ($errors->has('state'))
            <span class="help-block">
                <strong>{{ $errors->first('state') }}</strong>
            </span>
            @endif
        </div>

        <div class="col-md-6 form-group">
            <input class="form-control" type="text" name="city" id="newcity" value="" placeholder="Enter City">
        </div>

        <div class="col-md-6 form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
            <input id="zip" type="text" class="form-control" name="zip" placeholder="Zip" value="{{ old('zip') }}"
                data-bv-zipcode-country="true" required>
        </div>


        <div class="form-group" id="another-city">
            <input type="hidden" name="anotherCity" placeholder="Add another city" class="form-control" />
        </div>

    </div>

	<hr class="style1">
		<link rel="stylesheet" type="text/css" href="{{ asset('multicss/example-styles.css')}}">
		<div class="form-group">
			<span>What Industry are you in?</span>
			<select name="select_category[]"
				class="form-control {{ $errors->has('select_category[]') ? ' has-error' : '' }}" multiple id="langOpt"
				required>
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

	<div class="form-group {{ $errors->has('experties') ? ' has-error' : '' }}">
		<span>Can you describe your area of expertise and the specific services you offer to real estate professionals?</span>
		<textarea id="experties" class="form-control" name="experties" required>{{ old('experties') }}</textarea>
		@if ($errors->has('experties'))
		<span class="help-block">
			<strong>{{ $errors->first('experties') }}</strong>
		</span>
		@endif
	</div>
	
	<div class="form-group {{ $errors->has('special_services') ? ' has-error' : '' }}">
		<span>What distinguishes your services from competitors in the industry, and can you provide examples of successful projects you’ve worked on?</span>
		<textarea id="special_services" class="form-control" name="special_services" required>{{ old('special_services') }}</textarea>
		@if ($errors->has('special_services'))
		<span class="help-block">
			<strong>{{ $errors->first('special_services') }}</strong>
		</span>
		@endif
	</div>
	
	<div class="form-group {{ $errors->has('service_precautions') ? ' has-error' : '' }}">
		<span>How do you ensure your services align with the needs and preferences of realtors and their clients?</span>
		<textarea id="service_precautions" class="form-control" name="service_precautions" required>{{ old('service_precautions') }}</textarea>
		@if ($errors->has('service_precautions'))
		<span class="help-block">
			<strong>{{ $errors->first('service_precautions') }}</strong>
		</span>
		@endif
	</div>
	
	@php 
	$connect_realtor = old('connect_realtor');
	@endphp
	<div class="form-group">
		<div class="radio fancy_radio">
			<span>Are you open to collaborating with real estate professionals on an ongoing basis, and do you have experience working as part of a real estate team?</span>
			<div class="input-radio-group">
				<label class="radio-inline">
					<input id="connect_realtor_yes" class="form-control" type="radio" name="connect_realtor" value="yes" @if ($connect_realtor=="yes" ) checked="checked" @endif required /> <span>Yes</span>
				</label>
				<label class="radio-inline">
					<input id="connect_realtor_no" class="form-control" type="radio" name="connect_realtor" value="no" @if ($connect_realtor=="no" ) checked="checked" @endif required /><span>No</span>
				</label>
			</div>
		</div>
	</div>

	@php 
	$connect_memebrs = old('connect_memebrs');
	@endphp
	<div class="form-group">
		<div class="radio fancy_radio">
			<span>Are you open to collaborating with real estate professionals on an ongoing basis, and do you have experience working as part of a real estate team?</span>
			<div class="input-radio-group">
				<label class="radio-inline">
					<input id="connect_memebrs_yes" class="form-control" type="radio" name="connect_memebrs" value="yes" @if ($connect_memebrs=="yes" ) checked="checked" @endif required /> <span>Yes</span>
				</label>
				<label class="radio-inline">
					<input id="connect_memebrs_no" class="form-control" type="radio" name="connect_memebrs" value="no" @if ($connect_memebrs=="no" ) checked="checked" @endif required /><span>No</span>
				</label>
			</div>
		</div>
	</div>


    <input type="text" name="honey_pot" value="" style="display:none;">
	<hr class="style1">
	@if(env('APP_ENV') != 'local')
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
	@endif
    <div class="form-group justify-content-center">
        <button type="submit" class="btn btn-warning btn-lg mt-0 btn-yellow" id='registerVendor'>REGISTER</button>
    </div>

    <script type="text/javascript" src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.multi-select.js')}}"></script>
    <script type="text/javascript">
    $('#langOpt').multiSelect();
    $('#langOpt').on('change', function() {
        var selected = $(this).find("option:selected");
        var arrSelected = [];
        selected.each((idx, val) => {
            arrSelected.push(val.value);
        });
        if ($.inArray('19', arrSelected) >= 0) {
            $('#otherDesc').css('display', 'block');
        } else {
            $('#otherDesc').css('display', 'none');
            $('#other_description').val('');
        }
    });
    </script>
</div>