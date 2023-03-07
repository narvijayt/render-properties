@inject('states', 'App\Http\Utilities\Geo\USStates')

{{ csrf_field() }}
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

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	<input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', isset($user) && isset($user->email) ? $user->email : '' ) }}" required >
	<p id="email-error" class="error"></p>
	@if ($errors->has('email'))
		<span class="help-block">
			<strong>{{ $errors->first('email') }}</strong>
		</span>
	@endif
</div>
<div class="row util__collapse">
	<div class="col-xs-8">
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
</div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	<input id="password" type="password" class="form-control" name="password" placeholder="Password" required >
	@if ($errors->has('password'))
		<span class="help-block">
			<strong>{{ $errors->first('password') }}</strong>
		</span>
	@endif
</div>
<input type="hidden" name="user_type" value="">

<div class="form-group">
	<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Password Confirm" required >
</div>
<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
<input id="city" type="text" class="form-control" name="city" placeholder="City" value="{{ old('city') }}" required >
@if ($errors->has('city'))
	<span class="help-block">
			<strong>{{ $errors->first('city') }}</strong>
		</span>
	@endif
	</div>
<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
	<select class="form-control" name="state" required>
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
<div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
	<input type="text" class="form-control" name="zip" placeholder="Postal Code" value="{{ old('zip') }}" required >
</div>
<div class="checkbox">
    <label>
        <input id="" type="checkbox" name="anoymous">
		<small>
			Remain Anonymous
		</small>
    </label>
</div>
<div class="form-group">
	<button type="submit" class="btn btn-warning btn-block">
		Register
	</button>
</div>
