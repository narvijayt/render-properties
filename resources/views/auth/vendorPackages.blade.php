@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')

@section('title', 'Vendor Package')
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
{{---@component('pub.components.banner', ['banner_class' => 'lender'])
        <h1><b>VENDOR ADVERTISING PACKAGES</b></h1>
       <h3> Reach Top Permoming Lender And Real Estate Agents Online</h3>
@endcomponent ---}}

<div class="banner packages" style="background:url('{{url('img/packages-back.jpg')}}')no-repeat;">
    <div class="container crises-header">

        <h1 class="text-warning family-mont">VENDOR ADVERTISING PACKAGES</b></h1>
        <h3 class="text-white  family-mont"> Reach Top Permoming Lender And Real Estate Agents Online</h3>
        <!---- <h5 style="color:green;">During this time of crisis. Render stands with our members. Until further notice all membership monthly payments will be waived at this time.</h5>
	    <a href="{{url('vendor-package-payment?id='.$id.'&package=pick-a-city')}}"><button type="submit" class="btn btn-warning middle" style="margin-bottom: 42px;">REGISTER FREE</button></a>-->
    </div>
</div>
<div class="container package-header">
    <div class="row  pricing-outer">
        @if(!is_null($vendorPackages))
            @foreach($vendorPackages as $package)
                <div class="col-md-4 text-center">
                    <div class="pricing-table  text-center starter">
                        <div class="head">
                            <h3 class="period text-uppercase">{{ $package->packageType == "usa" ? "United States" : "Pick a ".$package->packageType }}</h3>
                        </div>

                        <div class="middle">
                            <h1 class="price"><span>$</span>{{ (get_decimal_value($package->basePrice) > 0) ? $package->basePrice : floor($package->basePrice)  }} <u>MO</u></h1>
                            <p class="small-price">{{ $package->packageType == "usa" ? "For One Month" : "For One City" }}</p>
                            @if(!is_null($package->addOnPrice))
                                <h1 class="price"><span>$</span>{{ (get_decimal_value($package->addOnPrice) > 0) ? $package->addOnPrice : floor($package->addOnPrice)  }} <u>MO</u></h1>
                                <p class="small-price">EACH ADDITIONAL*</p>
                            @endif
                            @if($package->packageType == "usa")
                                <h2 class="text-white highlighted-text">OWN THE U.S. IN YOUR INDUSTRY!!!</h2>
                            @endif
                        </div>
                        @php $id = Request::segment(2);@endphp
                        <a href="{{url('vendor-package-payment?id='.$id.'&package='.$package->id)}}"><button type="submit"
                                class="btn btn-warning">SELECT PACKAGE</button></a>
                    </div>
                </div>
            @endforeach
        @endif

        {{-- 
        <div class="col-md-4 text-center">
            <div class="pricing-table  text-center starter">
                <div class="head">
                    <h3 class="period">PICK A STATE</h3>
                </div>

                <div class="middle">
                    <h1 class="price"><span>$</span>799 <u>MO</u></h1>
                    <p class="small-price">FOR ONE STATE*</p>
                    <h1 class="price"><span>$</span>599 <u>MO</u></h1>
                    <p class="small-price">EACH ADDITIONAL*</p>
                </div>

                <a href="{{url('vendor-package-payment?id='.$id.'&package=pick-a-state')}}"><button type="submit"
                        class="btn btn-warning">SELECT PACKAGE</button></a>

            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="pricing-table  text-center starter">
                <div class="head">
                    <h3 class="period">UNITED STATES</h3>
                </div>

                <div class="middle">
                    <h1 class="price"><span>$</span>8995 <u>MO</u></h1>
                    <p class="small-price">FOR ONE MONTH</p>
                    <h2 class="text-white highlighted-text">OWN THE U.S. IN YOUR INDUSTRY!!!</h2>
                </div>
                <a href="{{url('vendor-package-payment?id='.$id.'&package=united-states')}}"><button type="submit"
                        class="btn btn-warning">SELECT PACKAGE</button></a>
            </div>
        </div>
        --}}
    </div>
</div>
@endsection