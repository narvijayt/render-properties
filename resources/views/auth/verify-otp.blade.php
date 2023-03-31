@extends('layouts.app')
@section('title') Verify OTP @endsection
@section('meta')
    @php
        $description = 'Verify your Mobile with OTP Code'
    @endphp
    {{ meta('description', $description) }}
    {{ meta('keywords', config('seo.keyword')) }}

    {{ openGraph('og:title', 'Verify OTP') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}

    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Verify OTP') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}

    {{ googlePlus('name', 'Verify OTP') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')
    @component('pub.components.banner', ['banner_class' => 'privacy'])
        <h1 class="banner-title">Verify OTP Code</h1>
    @endcomponent

    <div class="container text-center">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <div class="row">                    
                    <div class="col-md-12">
                        <h4>Enter Code</h4>
                       
                         @if (Session::has('message'))
                            <span class="help-block alert alert-success">
                                {{ Session::get('message') }}
                            </span>
                        @endif

                        @if (Session::has('error'))
                            <span class="help-block alert alert-danger">
                                {{ Session::get('error') }}
                            </span>
                        @endif
                        
                       
                        <form role="form" method="POST" action="{{ route('verify.otp') }}">
                            @if ($errors->has('otp'))
                                <span class="help-block alert alert-danger">OTP is required</span>
                            @endif

                            {{ csrf_field() }}

                            <input type="hidden" name="user_id" value="{{ $user->user_id }}" />
                            <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" id="otp" name="otp" value="{{ old('otp') }}" placeholder="OTP Code" maxlength="6" minlength="6" />
                            </div>

                            <button type="submit" class="btn btn-warning btn-block">Verify</button>
                        </form>
                        <p>Didn't receive the OTP?<a href="{{ route('resend.otp', ['id' => $user->user_id]) }}" class="btn btn-link">Send Again</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
