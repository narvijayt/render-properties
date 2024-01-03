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
                    <div class="col-lg-5 col-sm-9 hero-intro">
                        <!---<span>CONNECTING<br></span> Homes Buyers <span> to </span><br>Top Real Estate Agents<br><span>and</span> Loan Officers <br><span>in</span> YOUR LOCAL AREA-->
                        <!---Connecting <span>Home Buyers</span> and <span>Sellers</span> to  <span>Top Real Estate Agents,</span> <span>Trusted Mortgage Loan Officers</span> and <span>Reputable Home Service Providers</span> and <span>Vendors</span> -->
                       
    			        <h1 class="m-0">The Real Estate Network</h1>
                        <div class="home-banner-heading"><h2>Get Deals Sooner. <br> Close Deals Faster.</h2></div>
    					{{--<p>{!! get_application_name() !!} connects home<br>buyers and sellers to real estate<br>agents and loan officers.</p>--}}
						<p class="pr-4"><b>Realtors, Lenders, & Vendors.</b> <br> Connect with top-tier real estate pros that want to be contacted, grow your business, and expand your horizons.</p>
						<p class="mt-1"><b>SEE SUBSCRIPTIONS FOR…</b></p>
    					
                        {{-- <button type="button" class="btn btn-warning util__mb--small text-uppercase btn-registerModal" data-toggle="modal" data-target="#registerModal">SIGN UP NOW</button> --}}
						<div class="d-flex-btn-group">
                     <a class="btn btn-primary btn-yellow " href="{{ url('realtor-register') }}">REALTORS - FREE</button>
	               <a class="btn btn-primary btn-yellow " href="{{ url('lender-register') }}">LENDERS</a>
	            <a class="btn btn-primary btn-yellow " href="{{ url('vendor-register') }}">VENDORS</a>
	             </div>
                    </div>
                    <div class="col-lg-7 col-sm-3 hero-img-rt">				 
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
	<div class="render-network-section py-3">
	<div class="container">
	
	<h2 class="text-center text-white h1  mb-1 mt-0">The Render Network</h2>
	<p class="text-box-center text-left text-white"> Render is a social network exclusively for real estate professionals that want to connect with other real estate pros. We’re all working towards the same goals… get more deals, close more deals.</p>
	<div class="row ">
	<div class="col-md-12 center-box text-center mt-2">
	<div class="col-md-4 px-4">
	<img src="{{url('/')}}/img/connect-icon.png">
	<h3 class="text-orange">Get Seen by people <br> that want to connect:</h3>
	<p class="text-white">Render was designed to connect and match real estate pros that are open to new relationships. With Render, you can spread your name, build your reputation, scale your business, and do it all with professionals that are open and looking for your service. No more cold calling and talking to the wrong people.</p>
	</div>
	<div class="col-md-4 px-4">
	<img src="{{url('/')}}/img/monitoring-icon-02.png">
	<h3 class="text-orange">More Leads & Referrals:</h3>
	<p class="text-white">Everyone knows that the more you refer, the more referrals you’ll get. That’s what the Render Network is all about. Getting qualified leads is as easy as making a connection. Together, we all grow faster.</p>
	</div>
	<div class="col-md-4 px-4">
	<img src="{{url('/')}}/img/sale-icon-1.png">
	<h3 class="text-orange">Speed to Sale:</h3>
	<p class="text-white">It takes a whole crew to move a property. Realtors, Lenders, Inspectors, Contractors, Title Agents, Lawyers, Photographers, and maybe even a handful of dudes with a truck. And connecting with everyone you need to make that sale has never been easier with Render.</p>
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
                <div id="testimoniial-slider" class="carousel slide" data-ride="carousel">
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
                                <i class="fa fa-quote-right fa-3x fa-fw"></i>
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
	
	<div class="works-section-outer py-3">
        <div class="container">
		<div class="row ">
	<div class="col-md-12 center-box text-left mt-0">
	<div class="col-md-6 pr-4">
	<h2 class="text-left text-white h1  mb-1 mt-0">How It Works For…</h2>
	<div class="mobile-image"> <img src="{{url('/')}}/img/realtors-img-new.png"></div>
	<h4 class="text-left text-white m-0">Realtors:</h4>
	<p class="text-left text-white">
	 Whether you’re a seasoned real estate agent or just starting, Render Properties provides you with a platform to connect with the right lenders and vendors for your clients. Easily find mortgage experts, photographers, home stagers, and more to enhance your services and provide a comprehensive experience to your clients. 
	</p>
	<a class="sign-link text-orange" href="{{ url('realtor-register') }}">Free Sign Up For Realtors</a>
	</div>
	<div class="col-md-6 desktop-image">
	<img src="{{url('/')}}/img/realtors-img-new.png">
	</div>
	</div>
	
	<div class="col-md-12 center-box text-left mt-3">
	<div class="col-md-6 ">
	<img src="{{url('/')}}/img/lenders-img-new.png">
	</div>
	<div class="col-md-6 pl-4">
	<h4 class="text-left text-white m-0">Lenders:</h4>
	<p class="text-left text-white">
	For lenders, Render Properties offers a direct line to real estate professionals seeking financing solutions. Connect with realtors who are open to establishing new relationships and have clients in need of mortgage services, ensuring a seamless and efficient lending process. No more Cold Calling or meet and great. 
	</p>
	<a class=" sign-link text-orange" href="{{ url('lender-register') }}">Sign Me Up</a>
	</div>
	
	</div>
	
	<div class="col-md-12 center-box text-left mt-3 flex-box-section">
	<div class="col-md-6 pr-4 box-order-1">
	<h4 class="text-left text-white m-0">Vendors:</h4>
	<p class="text-left text-white">
	If you’re a vendor specializing in real estate services such as photography, staging, or property inspection, Render Properties is your gateway to a wider network of potential clients. Realtors on our platform are actively seeking new partnerships, allowing you to showcase your skills and offerings to those who need them. 
	</p>
	 <a class="sign-link text-orange" href="{{ url('vendor-register') }}">See My Subscription Options</a>
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
		<h2 class="text-center h1  mb-1 mt-0">All Profits Are Yours! <br> We Never Take A Cut.</h2>
		<p class="text-primary">Unlike other online marketplaces, we never take a dime of <br> your proceeds. You only pay for your monthly subscription, <br> so you can do all the deals you want risk-free.</p>
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
		<h2 class="text-left h1  mb-1 mt-0">Get Instant Access To <br> 1,000s Of Real Estate Pros, <br> Nationwide!</h2>
		
		<p class="text-primary">Render was created by The Carolinas leading mortgage and Real Estate broker Richard Tocado, with a little help from Jimmy Kelly. To boost his own business, Richard wound up creating the largest network of realtors and lenders in the country. Now, they’re bringing this powerful network to you. </p>
		<p class="text-primary">No more cold-calling. </p>
		<p class="text-primary">No more hours of searching for the pros.</p>
		<p class="text-primary">No more incompetent real estate pros.</p>
		<p class="text-primary">And you get access to talent nationwide.Sign up now and see what the Render network can do for you.</p>
		
		<div class="center-box text-left mt-1 mb-3 pt-1">
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
				  <a href="{{url('search-realtor-profiles')}}"  >		   
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
