@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')

@section('title', 'Register')
@section('meta')
    @php
        $description = 'Register for Render'
    @endphp
    {{ meta('description', $description) }}

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
        <h1><b>Platinum Membership Special Offer!</b></h1>
       <h3> Reach Top Permoming Lender And Real Estate Agents Online</h3>
@endcomponent ---}}


 <div class="banner packages" style="background:url('{{url('img/packages-back.jpg')}}')no-repeat;">
	<div class="container">
	  <h1 class="text-warning family-mont">Platinum Membership Special Offer!</b></h1> 
	  <h3 class="text-white  family-mont"> Reach Top Permoming Lender And Real Estate Agents Online</h3>
	   </div>
	</div>
	
<div class="container">
        <div class="row  pricing-outer">
		
            <div class="col-md-4 text-center">
                <div class="pricing-table  text-center starter">
                <div class="head"><h3 class="period">PICK A CITY</h3></div>
				
				  <div class="middle">
                                    <h1 class="price"><span>$</span>99 <u>MO</u></h1>
                                    <p class="small-price">For One City</p>
                                   <h1 class="price"><span>$</span>79 <u>MO</u></h1>
                                    <p class="small-price">EACH ADDITIONAL*</p>									
                                  </div>
                                 @php $id = Request::segment(2);@endphp
  <a href="{{url('vendor-package-payment?id='.$id.'&package=pick-a-city')}}"><button type="submit" class="btn btn-warning">SELECT PACKAGE</button></a>
               </div>
                   </div>
				  <div class="col-md-4 text-center">
                <div class="pricing-table  text-center starter">
                <div class="head"><h3 class="period">PICK A STATE</h3></div>
				
				  <div class="middle">
                                    <h1 class="price"><span>$</span>799 <u>MO</u></h1>
                                    <p class="small-price">FOR ONE STATE*</p>
                                   <h1 class="price"><span>$</span>599 <u>MO</u></h1>
                                    <p class="small-price">EACH ADDITIONAL*</p>									
                                  </div>

                <a href="{{url('vendor-package-payment?id='.$id.'&package=pick-a-state')}}"><button type="submit" class="btn btn-warning">SELECT PACKAGE</button></a>
              
                 </div>
                  </div>
				   <div class="col-md-4 text-center">
                <div class="pricing-table  text-center starter">
                <div class="head"><h3 class="period">UNITED STATES</h3></div>
				
				  <div class="middle">
                                    <h1 class="price"><span>$</span>8995 <u>MO</u></h1>
                                    <p class="small-price">FOR ONE MONTH</p>
                                    <h2 class="text-white highlighted-text">OWN THE U.S. IN YOUR INDUSTRY!!!</h2>									
                                  </div>
 <a href="{{url('vendor-package-payment?id='.$id.'&package=united-states')}}"><button type="submit" class="btn btn-warning">SELECT PACKAGE</button></a>
                 </div>
                  </div>
		</div>
    </div>
@endsection