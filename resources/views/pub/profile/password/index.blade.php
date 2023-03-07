@extends('pub.profile.layouts.profile')
@section('title','Change Password | Edit Profile')
@section('meta')
    {{ meta('description', config('seo.description')) }}
    {{ meta('keywords', config('seo.keyword')) }}
@endsection
@section('page_content')
    <div class="row">
        <div class="col-md-8">

            <form action="{{ route('pub.profile.password.update') }}" method="post">

                <h4 class="margin-top-none">User Information</h4>

                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                    <label for="current_password" class="control-label">Current Password</label>

                    <input id="current_password" type="password" class="form-control" name="current_password" required>

                    @if ($errors->has('current_password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                    @endif

                </div>

                <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                    <label for="new_password" class="control-label">New Password</label>

                    <input id="new_password" type="password" class="form-control" name="new_password" required>

                    @if ($errors->has('new_password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif

                </div>

                <div class="form-group">
                    <label for="new_password-confirm" class="control-label">Confirm New Password</label>

                    <input id="new_password-confirm" type="password" class="form-control" name="new_password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Change Password</button>

            </form>

        </div>

    </div>
@endsection