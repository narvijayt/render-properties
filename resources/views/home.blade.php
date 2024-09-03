@extends("layouts.app")
    @section('title', 'Home')
    @section('meta')
@if(!empty($meta))
@if(!is_null($meta->description))
{{ meta('description',html_entity_decode(strip_tags($meta->description))) }}
@else
{{ meta('description', config('seo.description')) }}
@endif
@if(!is_null($meta->keywords))
{{ meta('keywords', html_entity_decode(strip_tags($meta->keyword)))}}
@else
{{ meta('keywords', config('seo.keyword')) }}
@endif
@else
{{ meta('description', config('seo.description')) }}
{{ meta('keywords', config('seo.keyword')) }}
@endif
    {{ openGraph('og:title', 'Home') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', config('seo.description')) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:title', 'Home') }}
    {{ twitter('twitter:description', config('seo.description')) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Home') }}
    {{ googlePlus('description', config('seo.description')) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection
@section("content")
    <div class="hero-banner ">
        <div class="home-banner-container">
		{{-- <div class="home-banner-topbar">
                <div class="container"><h1>Real Estate <span class="">+</span> Lending <span class="">=</span> Deals</h1></div>
		</div> --}}
        
            <div class="banner-body-section">
                <div class="container">
                    <div class="row ">
                    <div class="col-lg-7 col-sm-9 hero-intro">
                        <!---<span>CONNECTING<br></span> Homes Buyers <span> to </span><br>Top Real Estate Agents<br><span>and</span> Loan Officers <br><span>in</span> YOUR LOCAL AREA-->
                        <!---Connecting <span>Home Buyers</span> and <span>Sellers</span> to  <span>Top Real Estate Agents,</span> <span>Trusted Mortgage Loan Officers</span> and <span>Reputable Home Service Providers</span> and <span>Vendors</span> -->
                       
    			        {{-- <h1 class="m-0">Welcome to Render The Real Estate Connection</h1>
                        <div class="home-banner-heading"><h2>We Connect Home <br> Buyers & Sellers With <br> Top-tier Real Estate Agents, <br> Loan Officers & Vendors.</h2></div>
						<p class="pr-4">Our platform empowers users to browse <br> and match with the best in the industry, <br> ensuring a seamless and successful <br> real estate experience.</p>
    					<p>{!! get_application_name() !!} connects home<br>buyers and sellers to real estate<br>agents and loan officers.</p>--}}
                        {!! $getHomePage->banner !!}
						{{--<<p class="mt-1"><b>SEE SUBSCRIPTIONS FOR…</b></p>--}}
    					
                        {{-- <button type="button" class="btn btn-warning util__mb--small text-uppercase btn-registerModal" data-toggle="modal" data-target="#registerModal">SIGN UP NOW</button> --}}
						<div class="d-flex-btn-group">
                            <a class="btn btn-primary btn-yellow property-btn" href="{{ route('property.buy') }}">BUY PROPERTY</a>
                            <a class="btn btn-primary btn-yellow property-btn" href="{{ route('property.sell') }}">SELL PROPERTY</a>
                            {{-- <a class="btn btn-primary btn-yellow " href="{{ url('vendor-register') }}">VENDORS</a> --}}
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-3 hero-img-rt">				 
    				    {{--<img src="{{url('/')}}/img/home-rt-images-2.png">--}}
    				   {{-- <img src="{{url('/')}}/img/home-banner.png"> --}}
                       <!-- <iframe src="https://player.vimeo.com/video/317507913" width="100%" height="288" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> -->
                        
                        <!--- <iframe src="https://player.vimeo.com/video/335478972" width="100%" height="288" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>-->
                         <!--- <iframe src="https://player.vimeo.com/video/356748145" width="100%" height="288" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>-->
                    
                            <!---iframe src="https://player.vimeo.com/video/335478972" width="100%" height="288" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe--->
    						<!---<iframe src="https://player.vimeo.com/video/335478972?title=0&byline=0&portrait=0" width="100%" height="288" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>--->
                    </div>
    				
                </div>
                </div>
            </div>
        </div>
    </div>
    @php /*
	<div class="counting-outer">
    	@if(config('app.home_page_show_statistics') === true && $realtorCount >= 100 && $brokerCount >= 100)
    
            <div class="container stats counting-section">
    
                <div class="row">
    
                    <!--<div class="col-md-3">{{--<h1>{{ $connectionCount }}</h1> Connections Made--}}</div> -->
    
                  <!--  <div class="col-md-3"><h1>1,117</h1><span> Connections Made</span></div>
    
                    <div class="col-md-3"><h1>2,357</h1> <span>Realtors</span></div>
    
                    <div class="col-md-3"><h1>1,720</h1> <span>Lenders</span></div>
    
                    <div class="col-md-3"><h1>1,655</h1> <span> Messages</span></div>
    
                    <div class="col-md-3">{{--<h1>{{ $messageCount }}</h1> Messages--}}</div>-->
    
                    {{-- <div class="col-md-3 col-sm-3 col-xs-6"><h2>{{ number_format($connectionCount) }}<!---1,289--> </h2><span> Connections Made</span></div> --}}
    
                    <div class="col-md-6 col-sm-6 col-xs-6"><h2>{{ number_format($realtorCount) }} <!---2,357--></h2> <span>Realtors</span></div>
    
                    <div class="col-md-6 col-sm-6 col-xs-6"><h2> {{ number_format($brokerCount) }} <!-- 1,720---></h2> <span>Lenders</span></div>
    
                    {{-- <div class="col-md-3 col-sm-3 col-xs-6"><h2>{{ number_format($messageCount) }} <!-- 1,655---></h2><span> Messages</span></div> --}}
    
                    
    
                    <!--<div class="col-md-12 text-center" style="margin-top:20px;">
    
                        <button type="button" class="btn btn-warning util__mb--small text-uppercase btn-registerModal" data-toggle="modal" data-target="#registerModal">Register Now</button>
    
                    </div> -->
    
                </div>
    
            </div>
    
            {{--@elseif(config('app.home_page_show_statistics') === true && $realtorCount >= 100 && $brokerCount >= 100)--}}
    
            {{--<div class="container stats">--}}
    
            {{--<div class="row">--}}
    
            {{--<div class="col-md-6"><h1>{{ $realtorCount }}</h1> <span>Realtors</span></div>--}}
    
            {{--<div class="col-md-6"><h1>{{ $brokerCount }}</h1> <span>Lenders</span></div>--}}
    
            {{--</div>--}}
    
            {{--</div>--}}
    
        @else
    
            <div class="container">
    
                <div class="row">
    
                    <div class="col-md-12 text-center">
    
                        <h3 style="margin-top: 45px"> Join Our Growing Community Today!</h3>
    
                        <button type="button" class="btn btn-warning util__mb--small text-uppercase btn-registerModal" data-toggle="modal" data-target="#registerModal">Register Now</button><br/>
    
                    </div>
    
                </div>
    
            </div>
    
        @endif	
	</div>
    */ 
    @endphp
    
    {{--<div class="container grow">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12 text-center">--}}
    {{--<h2>Are you a consumer in the market to buy a home?</h2>--}}
    {{--<a href="http://www.homewithrichard.com" class="btn btn-sm btn-warning util__mb--small">Visit Home With Richard</a> <br />--}}
    {{--Connect with our lenders and Real Estate Agents Today!--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
	
	<div class="join-render-section py-3">
	<div class="container">
	{!! $getHomePage->section_1 !!}
	<div class="col-md-12 center-box text-center mt-0 mb-0">
	<h4 class="text-center mb-0 text-primary">SIGN ME UP!</h4> 
	<div class="d-flex-btn-group justify-content-center"><a href="{{ route('realtor-register') }}" class="btn btn-primary btn-yellow ">REALTORS - FREE
	   </a>
	   <a href="{{ route('lender-register') }}" class="btn btn-primary btn-yellow ">LENDERS</a> 
	   <a href="{{ route('pick-package') }}" class="btn btn-primary btn-yellow ">VENDORS</a>
	   </div>
	   </div>
    </div>
	</div>
	</div>
	<div class="render-network-section py-3">
	<div class="container">
    @php
        $section2Array = '';
        if (!is_null($getHomePage->section_2)):
            $section2Array = (array) json_decode($getHomePage->section_2, true);
        endif;
    @endphp
	{!! $section2Array[subsection1] !!}
	<div class="row ">
	<div class="col-md-12 center-box text-center mt-2">
	<div class="col-md-4 px-4">
	<img src="{{url('/')}}/img/connect-icon.png">
	{!! $section2Array[subsection2] !!}
	</div>
	<div class="col-md-4 px-4">
	<img src="{{url('/')}}/img/monitoring-icon-02.png">
	{!! $section2Array[subsection3] !!}
	</div>
	<div class="col-md-4 px-4">
	<img src="{{url('/')}}/img/sale-icon-1.png">
    {!! $section2Array[subsection4] !!}
	</div>
	</div>
	<div class="col-md-12 center-box text-center mt-0 mb-3">
	<h4 class="text-white text-center mb-0">SIGN UP FOR…</h4>
	<div class="d-flex-btn-group justify-content-center">
      <a class="btn btn-primary btn-yellow " href="{{ url('realtor-register') }}">REALTORS - FREE</button>
	   <a class="btn btn-primary btn-yellow " href="{{ url('lender-register') }}">LENDERS</a>
	   <a class="btn btn-primary btn-yellow " href="{{ url('vendor-register') }}">VENDORS</a>
	    </div>
	
	</div>
	</div>
	</div>
	</div>
	
	<div class="testimonials">
        <div class="container">
		  <h2 class="h1 mt-0 mb-1">Testimonials</h2>
            @if(!empty($testimonials))
                <div id="testimoniial-slider" class="carousel slide carousel-fade" data-ride="carousel">
                @php $flag = 0; @endphp
                <ol class="carousel-indicators">
                    @foreach($testimonials as $testimonial)
                        @if($flag == 0)
                            <li data-target="#testimoniial-slider" data-slide-to="0" class="active"></li>
                        @else
                            <li data-target="#testimoniial-slider" data-slide-to="{{$flag}}"></li>
                        @endif
                        @php $flag++; @endphp
                    @endforeach
                </ol>
                <!-- Wrapper for carousel items -->
                <div class="carousel-inner">
                    @php $flag = 0; @endphp
                    @foreach($testimonials as $testimonial)
                        @if($flag == 0)
                            <div class="item carousel-item active">
                        @else
                            <div class="item carousel-item">
                        @endif
                          <p class="overview"><b>{{ucwords($testimonial['name'])}}</b></p>
                            <p class="testimonial">
                               
                                @php echo ucfirst(html_entity_decode($testimonial['description'])); @endphp
                            </p>
                           
                        </div>
                        @php $flag++; @endphp
                    @endforeach
                </div>
                <a class="carousel-control left carousel-control-prev" href="#testimoniial-slider" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="carousel-control right carousel-control-next" href="#testimoniial-slider" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            @endif
        </div>
		<div class="col-md-12 center-box text-center mt-0 mb-3">
	<h4 class="text-center mb-0">I WANT TO SEE MORE.</h4>
	<div class="d-flex-btn-group justify-content-center">
      <a class="btn btn-primary btn-yellow " href="{{ url('realtor-register') }}">REALTORS - FREE</button>
	   <a class="btn btn-primary btn-yellow " href="{{ url('lender-register') }}">LENDERS</a>
	   <a class="btn btn-primary btn-yellow " href="{{ url('vendor-register') }}">VENDORS</a>
	    </div>
	</div>
    </div>
	@php
        $section3Array = '';
        if (!is_null($getHomePage->section_3)):
            $section3Array = (array) json_decode($getHomePage->section_3, true);
        endif;
    @endphp
	<div class="works-section-outer py-3">
        <div class="container">
		<div class="row ">
	<div class="col-md-12 center-box text-left mt-0 how-it-work">
    
    {!! $section3Array[subsection1] !!} 
	<div class="col-md-6 desktop-image order-2">
	<img src="img/realtors-img-new.png">
	</div>
	</div>
	
	<div class="col-md-12 center-box text-left mt-3">
	<div class="col-md-6 ">
	<img src="{{url('/')}}/img/lenders-img-new.png">
	</div>
	<div class="col-md-6 pl-4">
	{!! $section3Array[subsection2] !!}
	</div>
	
	</div>
	
	<div class="col-md-12 center-box text-left mt-3 flex-box-section">
	<div class="col-md-6 pr-4 box-order-1">
   
	{!! $section3Array[subsection3] !!}
	</div>
	<div class="col-md-6  box-order-2">
	<img src="{{url('/')}}/img/vendors-img-new.png">
	</div>
	</div>
    </div>
    </div>
    </div>
	<div class="profits-section-outer">
        <div class="container pb-0">
		<div class="row ">
		<div class="col-md-12 center-box text-center mt-3 mobile-center-box">
		{!! $getHomePage->section_4 !!}
		<div class="col-md-12 center-box text-center mt-1 mb-3 ">
	<h4 class="text-center text-primary mt-0 mb-0 ">CHECK IT OUT!</h4>
	<div class="d-flex-btn-group justify-content-center">
      <a class="btn btn-primary btn-yellow " href="{{ url('realtor-register') }}">REALTORS - FREE</button>
	   <a class="btn btn-primary btn-yellow " href="{{ url('lender-register') }}">LENDERS</a>
	   <a class="btn btn-primary btn-yellow " href="{{ url('vendor-register') }}">VENDORS</a>
	    </div>
	</div>
		</div>
		</div>
    </div>
    </div>
	
	<div class="instant-access-outer">
        <div class="container pb-0">
		<div class="row ">
		<div class="col-md-12 center-box text-left">
		<div class="col-md-3">
		<img src="{{url('/')}}/img/richard-image-home.png">
		</div>
		<div class="col-md-9 instant-text">
		{!! $getHomePage->section_5 !!}
		<div class="center-box text-left mt-1 mb-3 pt-2">
	<h4 class="text-left text-primary mt-0 mb-0">SIGN ME UP!</h4>
	<div class="d-flex-btn-group">
      <a class="btn btn-primary btn-yellow " href="{{ url('realtor-register') }}">REALTORS - FREE</button>
	   <a class="btn btn-primary btn-yellow " href="{{ url('lender-register') }}">LENDERS</a>
	   <a class="btn btn-primary btn-yellow " href="{{ url('vendor-register') }}">VENDORS</a>
	    </div>
	</div>
		</div>
		</div>
    </div>
		
    </div>
    </div>
	
	
	<div id="myModal" class="modal fade searching-popup" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
	        <button type="button" class="close" data-dismiss="modal">&#10005;</button>
      <div class="modal-body text-center">
	  
	       <div class="row"> 
	       <div class="col-md-5 col-md-offset-1"> 	       
                <a href="{{url('search-realtor-profiles')}}" >
                    <img src="img/Real-Estate-Agent-icon.png">
                    <button type="button" class="btn btn-primary btn-block btn-lg">Search Real Estate Agent</button>
                </a>
		     </div>
		    <div class="col-md-5"> 	
				 <a href="{{url('search-lender-profiles')}}"  >
					<img src="img/Lender-icon.png">
				 <button type="button" class="btn btn-primary btn-block btn-lg">Search Lender</button>
				 </a>
		    </div>
		  </div>
		 
      </div>
    </div>

  </div>
</div>
 @if(isset($homePage) && !empty($homePage))
	 @if($homePage->footer != '')
    <div class="map-grow">
        <div class="container p-0">
           <div class="row text-center">
		   
		     
		      <div class="col-md-6 col-md-offset-3">
                 @php echo html_entity_decode($homePage->footer); @endphp
                  </div>
					
			</div>
        </div>
    </div>
	 @endif
	 @endif
    
    

    @if(config('app.home_page_show_statistics') === true && $realtorCount >= 100 && $brokerCount >= 100)
       
                   {{--<div class="col-md-3"><h2>{{ number_format($connectionCount) }}<!---1,289--> </h2><span> Connections Made</span></div>
                <div class="col-md-3"><h2>{{ number_format($realtorCount) }} <!---2,357--></h2> <span>Realtors</span></div>
                <div class="col-md-3"><h2> {{ number_format($brokerCount) }} <!-- 1,720---></h2> <span>Lenders</span></div>
                <div class="col-md-3"><h2>{{ number_format($messageCount) }} <!-- 1,655---></h2><span> Messages</span></div>--}}
                
                 
        {{--@elseif(config('app.home_page_show_statistics') === true && $realtorCount >= 100 && $brokerCount >= 100)--}}
        {{--<div class="container stats">--}}
        {{--<div class="row">--}}
        {{--<div class="col-md-6"><h1>{{ $realtorCount }}</h1> <span>Realtors</span></div>--}}
        {{--<div class="col-md-6"><h1>{{ $brokerCount }}</h1> <span>Lenders</span></div>--}}
        {{--</div>--}}
        {{--</div>--}}
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 style="margin-top: 45px"> Join Our Growing Community Today!</h3>
                    <button type="button" class="btn btn-warning util__mb--small text-uppercase btn-registerModal" data-toggle="modal" data-target="#registerModal">Register Now</button><br/>
                </div>
            </div>
        </div>
    @endif


<!-- Modal -->
    <div id="registerModal" class="modal fade searching-popup" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&#10005;</button>
                <div class="row" style="padding-top:30px;">
                    <div class="col-md-12 text-center">
                        <h4 class="modal-title text-uppercase">Register As</h4>
                    </div>
                </div>
                <div class="modal-body text-center">
                    <div class="row"> 
                        <div class="col-md-6">
                                <a href="{{ route('register', [ 'type' => 'realtor' ]) }}">		   
                                <img src="img/Real-Estate-Agent-icon.png">
                                <button type="button" class="btn btn-primary btn-block btn-md">Realtor</button>
                                </a>
                            </div>
                            <div class="col-md-6"> 	
                                <a href="{{ route('register', [ 'type' => 'lender' ]) }}">
                                    <img src="img/Lender-icon.png">
                                <button type="button" class="btn btn-primary btn-block btn-md">Lender</button>
                                </a>
                            </div>
                            {{--
                            <div class="col-md-4"> 	
                                <a href="{{ url('vendor-register') }}">
                                    <img src="img/seller.png">
                                <button type="button" class="btn btn-primary btn-block btn-md">Vendor</button>
                                </a>
                            </div>
                            --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

   
@endsection

@push('scripts-footer')
    <script>
        $('.slide').slick({
            autoplay: true,
            autoplaySpeed: 5000,
            nextArrow: '<button type="button" class="slick-next"><i class="fa fa-fw fa-2x fa-chevron-right"></i></button>',
            prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-fw fa-2x fa-chevron-left"></i></button>',
        })
    </script>
@endpush