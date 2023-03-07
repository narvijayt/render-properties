@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>You have been unsubscribed.</h3>

                <a href="{{ route('pub.profile.settings.index') }}">Email Preferences</a>
            </div>
        </div>
    </div>

@endsection