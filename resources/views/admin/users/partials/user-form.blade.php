@inject('titles', 'App\Http\Utilities\Titles')

{{ csrf_field() }}

@if(isset($user->user_id))
    <input type="hidden" name="user_id" value="{{ $user->user_id }}" />
@endif

<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
    <label class="control-label" for="username">
        @if($errors->has('username'))<i class="fa fa-times-circle-o"></i>@endif Username
    </label>
    <input
            type="text"
            class="form-control"
            placeholder="Enter Username"
            name="username"
            value="{{ old('username', (isset($user->username) ? $user->username : '')) }}">
    @if($errors->has('username'))
        <span class="help-block">{{ $errors->first('username') }}</span>
    @endif
</div>

<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
    <label class="control-label" for="first_name">
        @if($errors->has('first_name'))<i class="fa fa-times-circle-o"></i>@endif  First Name
    </label>
    <input
            type="text"
            class="form-control"
            placeholder="Enter First Name"
            name="first_name"
            value="{{ old('first_name', (isset($user->first_name) ? $user->first_name : '')) }}">
    @if($errors->has('first_name'))
        <span class="help-block">{{ $errors->first('first_name') }}</span>
    @endif
</div>

<div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
    <label class="control-label" for="last_name">
        @if($errors->has('last_name'))<i class="fa fa-times-circle-o"></i>@endif  Last Name
    </label>
    <input
            type="text"
            class="form-control"
            placeholder="Enter Last Name"
            name="last_name"
            value="{{ old('last_name', (isset($user->last_name) ? $user->last_name : '')) }}">
    @if($errors->has('last_name'))
        <span class="help-block">{{ $errors->first('last_name') }}</span>
    @endif
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label class="control-label" for="email">
        @if($errors->has('email'))<i class="fa fa-times-circle-o"></i>@endif  Email
    </label>
    <input
            type="text"
            class="form-control"
            placeholder="Enter Email"
            name="email"
            value="{{ old('email', (isset($user->email) ? $user->email : '')) }}">
    @if($errors->has('email'))
        <span class="help-block">{{ $errors->first('email') }}</span>
    @endif
</div>

@if(isset($include_pass) && $include_pass === true)
    @include('admin.users.partials.user-password-form')
@endif

<div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
    <label for="active" class="control-label">Account Status</label>

    <div class="radio">
        <label>
            <input type="radio" name="active" value="0" {{ collect(old('active', (isset($user->active) && $user->active === true
                        ? true
                        : false
                    )))->contains('0') ? 'checked' : '' }}> Inactive
        </label>
    </div>
    <div class="radio">
        <label>
            <input type="radio" name="active" value="1" {{ collect(old('active', (isset($user->active) && $user->active === true
                        ? true
                        : false
                    )))->contains('1') ? 'checked' : '' }}> Active
        </label>
    </div>
    @if ($errors->has('active'))
        <span class="help-block">
            <strong>{{ $errors->first('active') }}</strong>
        </span>
    @endif
</div>

<button type="submit" class="btn btn-primary">Save</button>