@if(isset($user->user_id))
<input type="hidden" name="user_id" value="{{ $user->user_id }}" />
@endif


<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
    <label class="control-label" for="first_name">
        @if($errors->has('first_name'))<i class="fa fa-times-circle-o"></i>@endif First Name
    </label>
    <input type="text" class="form-control" placeholder="Enter First Name" name="first_name"
        value="{{ old('first_name', (isset($user->first_name) ? $user->first_name : '')) }}">
    @if($errors->has('first_name'))
    <span class="help-block">{{ $errors->first('first_name') }}</span>
    @endif
</div>

<div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
    <label class="control-label" for="last_name">
        @if($errors->has('last_name'))<i class="fa fa-times-circle-o"></i>@endif Last Name
    </label>
    <input type="text" class="form-control" placeholder="Enter Last Name" name="last_name"
        value="{{ old('last_name', (isset($user->last_name) ? $user->last_name : '')) }}">
    @if($errors->has('last_name'))
    <span class="help-block">{{ $errors->first('last_name') }}</span>
    @endif
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label class="control-label" for="email">
        @if($errors->has('email'))<i class="fa fa-times-circle-o"></i>@endif Email
    </label>
    <input type="text" class="form-control" placeholder="Enter Email" name="email"
        value="{{ old('email', (isset($user->email) ? $user->email : '')) }}">
    @if($errors->has('email'))
    <span class="help-block">{{ $errors->first('email') }}</span>
    @endif
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
            <label class="control-label" for="phone_number">
                @if($errors->has('phone_number'))<i class="fa fa-times-circle-o"></i>@endif Phone
            </label>
            <?php
            if($user->phone_number !=""){
                $user->phone_number = str_replace("-", "", $user->phone_number);
            }
            ?>
            <input type="text" class="form-control" placeholder="Enter Phone Number" name="phone_number"
                data-politespace {{--data-politespace-us-telephone--}} data-politespace-strip="[^\d]*"
                data-politespace-grouplength="3,3,4" data-politespace-delimiter="-" {{--maxlength="10"--}} type="tel"
                value="{{ old('phone_number', (isset($user->phone_number) ? $user->phone_number : '')) }}">
            @if($errors->has('phone_number'))
            <span class="help-block">{{ $errors->first('phone_number') }}</span>
            @endif
        </div>
    </div>
    @if(auth()->user()->user_type != 'vendor' && auth()->user()->user_type !='realtor' && auth()->user()->user_type !=
    'broker')
    <div class="col-xs-4">
        <div class="form-group {{ $errors->has('phone_ext') ? 'has-error' : '' }}">
            <label class="control-label" for="phone_ext">
                @if($errors->has('phone_ext'))<i class="fa fa-times-circle-o"></i>@endif Ext.
            </label>
            <input type="text" class="form-control" placeholder="Extension" name="phone_ext"
                value="{{ old('phone_ext', (isset($user->phone_ext) ? $user->phone_ext : '')) }}">
            @if($errors->has('phone_ext'))
            <span class="help-block">{{ $errors->first('phone_ext') }}</span>
            @endif
        </div>
    </div>
    @endif
</div>

<div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
    <label class="control-label" for="website">
        @if($errors->has('website'))<i class="fa fa-times-circle-o"></i>@endif Website
    </label>
    <input type="text" class="form-control" placeholder="Enter Website URL" name="website"
        value="{{ old('website', (isset($user->website) ? $user->website : '')) }}">
    @if($errors->has('website'))
    <span class="help-block">{{ $errors->first('website') }}</span>
    @endif
</div>

<div class="form-group {{ $errors->has('firm_name') ? 'has-error' : '' }}">
    <label class="control-label" for="firm_name">
        @if($errors->has('firm_name'))<i class="fa fa-times-circle-o"></i>@endif Company Name
    </label>
    <input type="text" class="form-control" placeholder="Enter Company Name" name="firm_name"
        value="{{ old('firm_name', (isset($user->firm_name) ? $user->firm_name : '')) }}">
    @if($errors->has('firm_name'))
    <span class="help-block">{{ $errors->first('firm_name') }}</span>
    @endif
</div>
@if(auth()->user()->user_type != 'vendor')
<div class="form-group {{ $errors->has('license') ? 'has-error' : '' }}">
    <label class="control-label" for="license">
        @if($errors->has('license'))<i class="fa fa-times-circle-o"></i>@endif License#
    </label>
    <input type="text" class="form-control" placeholder="Enter license" name="license"
        value="{{ old('firm_name', (isset($user->license) ? $user->license : '')) }}">
    @if($errors->has('license'))
    <span class="help-block">{{ $errors->first('license') }}</span>
    @endif
</div>
@endif