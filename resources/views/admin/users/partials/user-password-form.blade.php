<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label class="control-label" for="password">
        @if($errors->has('password'))<i class="fa fa-times-circle-o"></i>@endif Password
    </label>
    <input
            type="password"
            class="form-control"
            placeholder="Enter Password"
            name="password"
            value="{{ old('password') }}">
    @if($errors->has('password'))
        <span class="help-block">{{ $errors->first('password') }}</span>
    @endif
</div>

<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
    <label class="control-label" for="password_confirmation">
        @if($errors->has('password_confirmation'))<i class="fa fa-times-circle-o"></i>@endif Confirm Password
    </label>
    <input
            type="password"
            class="form-control"
            placeholder="Enter Password Confirmation"
            name="password_confirmation"
            value="{{ old('password_confirmation') }}">
    @if($errors->has('password_confirmation'))
        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
    @endif
</div>