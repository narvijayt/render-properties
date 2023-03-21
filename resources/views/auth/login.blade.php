@extends('layouts.app')
@section('title') Login @endsection
@section('meta')
    @php
        $description = 'Login to Render'
    @endphp
    {{ meta('description', $description) }}
    {{ meta('keywords', config('seo.keyword')) }}

    {{ openGraph('og:title', 'Login') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}

    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Login') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}

    {{ googlePlus('name', 'Login') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')
    @component('pub.components.banner', ['banner_class' => 'privacy'])
    <h1 class="banner-title">Member Login</h1>
    @endcomponent

    <div class="container text-center">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">

                <div class="row">
                    <div class="col-md-6 col-md-push-6">
					
					     <!---div class="util__mb--large">
                            <h4>Social Account</h4>
                            <a href="https://www.realbrokerconnection.com/auth/facebook" class="btn btn-facebook">
                                <i class="fa fa-facebook"></i> Login with Facebook
                            </a>
                        </div-->

                        <h4>Not a member yet?</h4>
                        <ul class="list-unstyled">
                             <li><a href="{{ route('register', [ 'type' => 'realtor' ]) }}" class="btn btn-warning" style="margin-bottom:10px">Real Estate Agents</a></li>
                    <li><a href="{{ route('register', [ 'type' => 'lender' ]) }}" class="btn-warning btn">Loan Officers</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-md-pull-6">
                        <h4>Existing Members</h4>
                        <!---<div class="alert alert-success">During this time of crisis. Render stands with our members. Until further notice all membership monthly payments will be waived at this time.</div>--->
                       
                         @if (Session::has('message'))
                            <span class="help-block alert alert-danger">
                                {{ Session::get('message') }}
                            </span>
                        @endif
                        
                        
                       
                        <form role="form" method="POST" action="{{ route('login') }}">
                            @if ($errors->has('email'))
                                <span class="help-block alert alert-danger">You have entered an invalid email or password.</span>
                            @endif

                            {{ csrf_field() }}
                            <div class="otp-error-response"></div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email or Phone Number" />
                                <button type="button" class="text text-primary f-right btn-text mb-10 otp-login-btn">Login with OTP</button>
                                <input type="hidden" name="loginWithOTP" value="0" />
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <div class="text-left">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning btn-block">Login</button>
                        </form>

                        <p>
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </p>
                    </div>
                </div>


            </div>

        </div>
    </div>
@endsection

    