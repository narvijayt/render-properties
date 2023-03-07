@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')

    @section('title', 'Vendor Payment')
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
        <h1><b>VENDOR PAYMENT</b></h1>
       <h3></h3>
    @endcomponent 

<section class="bg-grey py-3">	
<div class="container">
            <div class="text-block ">
                 @if(session()->has('message'))
                    <div class="alert">
                        {{ session()->get('message') }}
                    </div>
                    @endif
                @if(session('error'))
                        <div class="alert alert-danger">{{session('error')}}</div>
                  @endif
				<div class="alert alert-success"> 
              <strong>			
             
              You have selected vendor registration for @if($findPackagePrice->slug == 'for-united-states')United States @endif
               @if($findPackagePrice->slug == 'for-one-city' && $findPackagePrice->slug =='for-one-city-additional')Pick A City @endif
               @if($findPackagePrice->slug == 'for-one-state-additional' && $findPackagePrice->slug == 'for-one-state')PICK A State @endif
               ({{$findPackagePrice->name}}) at ${{$findPackagePrice->cost }}
               </strong>			  
			  </div>
			   
			   @if(count($selectedPackageDetails) > 0 )
			   	<div class="alert alert-success"> 
              <strong>
			  @foreach($selectedPackageDetails as $packagesel)
              @if($packagesel->additional_city !="" && $packagesel->package_selected_city !="")
              @php $additionalCity = count(explode(',',$packagesel->additional_city));@endphp
                You have to pay <b>${{99.00 + $additionalCity * $findPackagePrice->cost }}</b> for {{$additionalCity}} additional Cities.
                @endif
              @if($packagesel->additional_state !="" && $packagesel->package_selected_state !="")
               @php $additionalSte = count(explode(',',$packagesel->additional_state));@endphp
                You have to pay <b>${{799.00 + $additionalSte * $findPackagePrice->cost }}</b> for {{$additionalSte}} additional States.
                @endif
                @if($packagesel->additional_city =="" && $packagesel->package_selected_city !="")
                 You have to pay <b>${{$findPackagePrice->cost }}</b> {{$findPackagePrice->name}}.
                @endif
                 @if($packagesel->additional_state =="" && $packagesel->package_selected_state !="")
                 You have to pay <b>${{$findPackagePrice->cost }}</b> {{$findPackagePrice->name}}.
                @endif
             @endforeach
             
             @if($findPackagePrice->braintree_plan_id == 11)
              You have to pay <b>${{$findPackagePrice->cost }}</b> {{$findPackagePrice->name}}.
             @endif
              </strong>			  
			  </div>
			   @endif
			  
               </div>
			   
			 <div class="clearfix"></div><br>  
			   
        
               <form class="form vendor_register" id="doPayment" method="post">
			   <div class="">
                   <input type="hidden" name="user_id" value="{{$userDetails->user_id}}" id="vendorId">
                   <input type="hidden" name="braintree_planid" value="{{$findPackagePrice->braintree_plan_id}}" id="packagePrice">
                   <input type="hidden" name="braintree_price" value="{{$findPackagePrice->cost }}" id="packagePrice">
                    @foreach($selectedPackageDetails as $packagesel)
                    @if($packagesel->additional_city !="")
              @php $additionalCity = count(explode(',',$packagesel->additional_city));@endphp
                <input type="hidden" name="total_amount" value="{{99.00 + $additionalCity * $findPackagePrice->cost }}">
                @endif
                 @if($packagesel->additional_state !="")
               @php $additionalSte = count(explode(',',$packagesel->additional_state));@endphp
               <input type="hidden" value="{{799.00 + $additionalSte * $findPackagePrice->cost }}" name="total_amount">
                @endif
                 @endforeach
                 @if($findPackagePrice->braintree_plan_id == 11)
                 <input type="hidden" value="8995.00" name="total_amount">
                 @endif
                 
                 @if($findPackagePrice->braintree_plan_id == 7)
                  <input type="hidden" value="99.00" name="total_amount">
                 @endif
                 
                 @if($findPackagePrice->braintree_plan_id == 9)
                  <input type="hidden" value="799.00" name="total_amount">
                 @endif
                <div class="col-lg-5 p-0 mb-2 d-none d-md-block">
                <div class="package-infobox">
				
				            <div class="box-title-box">
								<h1 class="box-title line-left family-mont">Your Card Preview</h1>								 							 
								</div>
				
							<div class="card-wrapper"></div>
						</div>
						</div>
						<div class="col-lg-7 vendor-reg-box">
							
							<div class="box-title-box">
								<h1 class="box-title line-left family-mont">Payment Details</h1>
								 <p>Please enter your payment details</p>							 
								</div>
								
							<div class="card-form">
								<div class="form-group">
									<div class="radio fancy_radio">
										<label><input name="namehere" type="radio"><span>Credit Card</span>
										<br> 
										</label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-7">
										<div class="form-group">
											<input required type="text" class="form-control form-control-lg card-number" name="number" id="card-number" maxlength="19" placeholder="Card Number">
										</div>
									</div>
									<div class="col-md-3 col-sm-6 col-xs-6">
										<div class="form-group">
											<input required type="text" class="form-control card-expiry form-control-lg date-formatter" name="expiry" id="date-format" placeholder="EXP">
										</div>
									</div>
									<div class="col-md-2 col-sm-6 col-xs-6">
										<div class="form-group">
											<input required type="text" class="form-control card-cvc form-control-lg" name="cvc" id="card-cvc" maxlength="16" placeholder="CVC">
										</div>
									</div>
								</div>
								<div class="form-group">
									<input required type="text" class="form-control card-name form-control-lg" name="name" id="card-name" placeholder="Card Holder Name">
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-lg btn-success btn-min-width" id="doPaymentButton">Continue</button>
								</div>
							</div>
						</div>  
						</div>
						</form>
      
       
    </div>
    </section>
		<style>.banner{margin-bottom:0}.footer{margin-top:0}</style>
  @endsection