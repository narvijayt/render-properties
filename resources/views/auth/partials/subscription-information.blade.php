@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')
@section('title', 'Payment Package')
@section('meta')
    @php
        $description = 'Register for Render'
    @endphp
    {{ meta('description', $description) }}
    {{ meta('keywords', config('seo.keyword')) }}
    {{ openGraph('og:title', 'Register') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}

    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Register') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}

    {{ googlePlus('name', 'Register') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection
@section('content')
    @component('pub.components.banner', ['banner_class' => 'lender'])
        Payment Package
    @endcomponent
  
    <style>.banner{margin:0}.footer{margin-top:0}</style> 
    <section class="bg-grey py-3">
        <div class="container">
            <div class="row">
                @if(session()->has('message'))
                    <div class="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif
             
                <p>We have received your request successfully to re-activate your subscription plan. Your memebrship will be active in time and you will get payment invoice in your inbox. Below are your payment details. </p>
                <div class="panel panel-success">
                    <div class="panel-heading">Subscription Activate Request Received!</div>
                    <div class="panel-body">
                        <div class="row form-group mb-2">
                            <div class="col-md-3">Plan</div>
                            <div class="col-md-9">Monthly Lender Membership For $19.80 USD</div>
                        </div>
                        <div class="row form-group mb-2">
                            <div class="col-md-3">Price</div>
                            <div class="col-md-9">$19.80</div>
                        </div>
                        <div class="row form-group mb-2">
                            <div class="col-md-3">Status</div>
                            <div class="col-md-9">Pending</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
