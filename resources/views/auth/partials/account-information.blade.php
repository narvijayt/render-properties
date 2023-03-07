@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')
@section('title', 'Real Estate + Lending = Deals')
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
        Real Estate + Lending = Deals
    @endcomponent
  
    <style>.banner{margin:0}.footer{margin-top:0}</style> 
    <section class="py-2">
        <div class="container">
            <div class="row text-dark">
                @if(session()->has('message'))
                    <div class="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif
             
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h4 class="mb-3">A loan officer partner will be reaching out to you soon to begin the process of setting up the CRM and starting the first time buyer lead program.</h4>
                
                    <p class="register-info-left"><h2 class="mt-0 mb-3">If you need pricing and availability information, please call or text <a href="tel:7045695072">704-569-5072</a>.</h2></p>
                </div>
            </div>
        </div>
    </section>
@endsection