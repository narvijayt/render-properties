@extends('admin.layouts.main')
@section('content')
 @if(session()->has('message'))
                    <div class="alert">
                        {{ session()->get('message') }}
                    </div>
                    @endif
             @if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
         @endif
         
 <div class="col-md-4 text-center">
                <div class="pricing-table  text-center starter">
                <div class="head"><h3 class="period">PICK A CITY</h3></div>
				<div class="middle">
                                    <h1 class="price"><span>$</span>995 <u>YR</u></h1>
                                    <p class="small-price">For One City</p>
                                   <h1 class="price"><span>$</span>795 <u>YR</u></h1>
                                    <p class="small-price">EACH ADDITIONAL*</p>									
                                  </div>
                                 @php $id = Request::segment(3);@endphp
  <a href="{{url('/cpldashrbcs/package-payment?id='.$id.'&package=pick-a-city')}}"><button type="submit" class="btn btn-warning">SIGNUP NOW</button></a>
               </div>
                   </div>
				  <div class="col-md-4 text-center">
                <div class="pricing-table  text-center starter">
                <div class="head"><h3 class="period">PICK A STATE</h3></div>
				
				  <div class="middle">
                                    <h1 class="price"><span>$</span>8995 <u>YR</u></h1>
                                    <p class="small-price">FOR ONE STATE*</p>
                                   <h1 class="price"><span>$</span>6995 <u>YR</u></h1>
                                    <p class="small-price">EACH ADDITIONAL*</p>									
                                  </div>

                <a href="{{url('/cpldashrbcs/package-payment?id='.$id.'&package=pick-a-state')}}"><button type="submit" class="btn btn-warning">SIGNUP NOW</button></a>
              
                 </div>
                  </div>
				   <div class="col-md-4 text-center">
                <div class="pricing-table  text-center starter">
                <div class="head"><h3 class="period">UNITED STATES</h3></div>
				
				  <div class="middle">
                                    <h1 class="price"><span>$</span>97995 <u>YR</u></h1>
                                    <p class="small-price">FOR ONE YEAR</p>
                                    <h2 class="text-white highlighted-text">OWN THE U.S. IN YOUR INDUSTRY!!!</h2>									
                                  </div>
 <a href="{{url('/cpldashrbcs/package-payment?id='.$id.'&package=united-states')}}"><button type="submit" class="btn btn-warning">SIGNUP NOW</button></a>
                 </div>
                  </div>
		
    @endsection