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
            <div class="home-banner-topbar">
                <div class="container"><h1>Real Estate <span class="">+</span> Lending <span class="">=</span> Deals</h1></div>
            </div>
        
            <div class="banner-body-section">
                <div class="container">
                    <div class="row ">
                    <div class="col-sm-6 hero-intro">
                        <!---<span>CONNECTING<br></span> Homes Buyers <span> to </span><br>Top Real Estate Agents<br><span>and</span> Loan Officers <br><span>in</span> YOUR LOCAL AREA-->
                        <!---Connecting <span>Home Buyers</span> and <span>Sellers</span> to  <span>Top Real Estate Agents,</span> <span>Trusted Mortgage Loan Officers</span> and <span>Reputable Home Service Providers</span> and <span>Vendors</span> -->
                        <div class="col-sm-5 hero-img-mobile">
    				        {{--<img src="{{url('/')}}/img/hero-mobile-image-01.png">--}}
    				        <img src="{{url('/')}}/img/home-banner.png">
    			        </div>
    			        
                        <div class="home-banner-heading">Render: the connecting<br>point like no other.</div>
    					<p>Render connects home<br>buyers and sellers to real estate<br>agents and loan officers.</p>
    					
                        <button type="button" class="btn btn-warning util__mb--small text-uppercase btn-registerModal" data-toggle="modal" data-target="#registerModal">SIGN UP NOW</button>
                    </div>
                    <div class="col-sm-6 hero-img-rt">				 
    				    {{--<img src="{{url('/')}}/img/home-rt-images-2.png">--}}
    				    <img src="{{url('/')}}/img/home-banner.png">
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
    <div class="member-spotlight c-pt-3" style="">
        <div class="container" style="">
		
		     
            <div class="row agents-outer">
                <div class="col-md-12">
					<p class="text-center mb-2">Connect with Trusted Mortgage Loan Officers & Top Real Estate Agents NOW!</p>
                    <h1 class="text-center spotlight__section-title mb-3">Gain Access to Render’s Vetted, Exclusive Database</h1>
                </div>
            </div>
            <div class="row">
                
                <?php /** @var \App\User $user */ ?>
                @foreach($spotlightUsers as $user)
                <div class=" col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center mb-1 @if ($user->designation !="" && $user->designation !='null' ) standard-agent @endif">
                      <div class="profile-box-inner">
                  <div class="designation" style="display:none"><label>@if($user->designation !="" && $user->designation !='null'){{$user->designation}}@endif </label> <img src="{{ asset('img/ribben.png') }}"></div>
         <img src="{{ $user->avatarUrl(\App\Enums\AvatarSizeEnum::MEDIUM) }}" class="search-result__avatar"> 
                    <h4 class="mb-0 pb-0">
                        <a href="{{ route('pub.user.show', $user->user_id) }}">{{ $user->first_name }}</a>
                         <small class="spotlight__user-detail"><strong class="text-dark"> 
                         @if($user->user_type == 'realtor'){{ucwords('real estate agent')}}@endif
                         @if($user->user_type == 'broker'){{ucwords('lender')}}@endif
                         @if($user->user_type == 'vendor'){{ucwords('vendor')}}@endif
                         </strong></small>
                        </h4>
                        <p class="pt-2">
            <i class="fa fa-map-marker"></i>  @if($user->state !="")@if($user->city !=""){{str_limit($user->city,10) }},@endif {{ $user->state }}@endif</p> <p>
                                <a href="{{ route('pub.user.show', $user->user_id) }}" class="btn btn-warning search-result__profile-link">View Profile</a>
                                </p>
                                </div>
                                </div>
                                @endforeach
                                
                                
               
				  <div class="col-md-12 mb-2 d-inline-block">
			<a data-toggle="modal" data-target="#myModal1" class="btn btn-warning util__mb--small border-btn text-uppercase btn-searcModal">Search Profiles</a>
			</div>
            </div>
		
			
		</div>
    </div>
	
	<div class="testimonials">
        <div class="container">
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
                         
                            <p class="testimonial">
                                <i class="fa fa-quote-right fa-3x fa-fw"></i>
                                @php echo ucfirst(html_entity_decode($testimonial['description'])); @endphp
                            </p>
                            <p class="overview"><b>{{ucwords($testimonial['name'])}}</b></p>
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
    </div>

    <div class="pitch pitch-outer">
        <div class="container">
            <div class="row">
			<div class=" col-md-12">
			<h2 class="text-center">Select to Connect</h2>
			<p  class="text-center">Connect with Trusted Mortgage Loan Officers & Top Real Estate Agents NOW!</p>
			</div>
			<div class="col-md-8 col-md-offset-2 col-xs-offset-0 col-xs-12">
                <div class="col-md-6 pitch__item">
                        <div class="agent-btn">
                            @if(isset($homePage) && !empty($homePage))
                                @if($homePage->realtor_box_content != '')
                                <a href="{{ route('register', [ 'type' => 'realtor' ]) }}" style="display: block;"  ><p>{{$homePage->realtor_box_content}}</p></a>
                                @else
                                    {{--<p>I'm a Real Estate Agent</p>
                                    <a href="{{ route('register', [ 'type' => 'realtor' ]) }}" class="btn btn-warning text-uppercase btn-registerModal" >Register Now</a>--}}
									 <a href="{{ route('register', [ 'type' => 'realtor' ]) }}" class="btn btn-warning text-uppercase btn-registerModal" >I AM A REAL ESTATE AGENT</a>
                                @endif
                            @else
                                <p>I'm a Real Estate Agent</p>
                                <a href="{{ route('register', [ 'type' => 'realtor' ]) }}" class="btn btn-sm btn-warning text-uppercase btn-registerModal" >Register Now</a>
                            @endif
                        </div>
                    {{--<h3 class="text-center">Sign up to enjoy these benefits:</h3>--}}
                    {{--<ul>--}}
                    {{--<li>Build your referral/lead network with active real estate buyer agents / You keep 100% of the referral fee</li>--}}
                    {{--<li>Marketing of your bio and personal website</li>--}}
                    {{--<li>Receive 30 days real estate coaching from nationally renowned Bill "The Coach" Sparkman</li>--}}
                    {{--<li>Online marketing presence for consumers searching for real estate professionals</li>--}}
                    {{--<li>Receive Mortgage pre approved buyer leads from Lenders. 95% of the clients looking to get pre approved do not--}}
                    {{--have a real estate agent and our lender partners refer them out to real estate agents on the site.</li>--}}
                    {{--<li>Connect with a Lender that will be a benefit to your career</li>--}}
                    {{--</ul>--}}

                    {{--<div class="pitch__links hidden-md hidden-lg">--}}
                    {{--<a href="{{ route('register') }}" class="btn btn-warning pitch__link">Sign Up</a>--}}
                    {{--<a href="{{ route('register') }}" class="pitch__link">View Pricing, Terms &amp; Conditions</a>--}}
                    {{--</div>--}}
                </div>
                <div class="col-md-6 pitch__item">
                        <div class="lender-btn">
                           @if(isset($homePage) && !empty($homePage))
                                @if($homePage->lender_box_content != '')
                                    <p>{{$homePage->lender_box_content}}</p>
                                @else
                                      {{--<p>I'm a Lender</p>
                                    <a href="{{ route('register', [ 'type' => 'lender' ]) }}" class="btn btn-warning text-uppercase btn-registerModal" >Register Now</a>--}}
									<a href="{{ route('register', [ 'type' => 'lender' ]) }}" class="btn btn-warning text-uppercase btn-registerModal" >I AM A LENDER</a>
                                @endif
                            @else
                                <p>I'm a Lender</p>
                                <a href="{{ route('register', [ 'type' => 'lender' ]) }}" class="btn btn-warning text-uppercase btn-registerModal" >Register Now</a>
                            @endif
                        </div>
                    {{--<h3 class="text-center">Sign up to enjoy these benefits:</h3>--}}
                    {{--<ul>--}}
                    {{--<li>Connect with active, productive buyers real estate agents</li>--}}
                    {{--<li>Build your real estate agent referral/lead network</li>--}}
                    {{--<li>Search and find top producing buyer real estate agents in your area that want to be--}}
                    {{--connected to a new lender--}}
                    {{--</li>--}}
                    {{--<li>Low cost mortgage pre-approval leads available</li>--}}
                    {{--<li>Receive reviews from your connection</li>--}}
                    {{--<li>Receive 30 days mortgage coaching from nationally renowned Bill "The Coach" Sparkman</li>--}}
                    {{--<li>Online marketing presence for consumers searching mortgage professionals</li>--}}
                    {{--</ul>--}}

                    {{--<div class="pitch__links hidden-md hidden-lg">--}}
                    {{--<a href="{{ route('register') }}" class="btn btn-warning pitch__link">Sign Up</a>--}}
                    {{--<a href="{{ route('register') }}" class="pitch__link">View Pricing, Terms &amp; Conditions</a>--}}
                    {{--</div>--}}
                </div>

                {{--
                    <div class="col-md-4 pitch__item">
                        <div class="consumer-btn">
    						 <a href="{{ url('/vendor-register') }}" class="btn btn-warning text-uppercase btn-registerModal" >I AM A VENDOR</a>
                        </div>                    
                    </div>
                --}}
                
            </div>
            </div>

            {{--<div class="row hidden-xs hidden-sm">--}}
            {{--<div class="col-md-6 text-center">--}}
            {{--<a href="{{ route('register') }}" class="btn btn-warning util__mb">Sign Up</a><br/>--}}
            {{--<a href="{{ route('register') }}" class="util__mb">View Pricing, Terms &amp; Conditions</a>--}}
            {{--</div>--}}
            {{--<div class="col-md-6 text-center">--}}
            {{--<a href="{{ route('register') }}" class="btn btn-warning util__mb">Sign Up</a><br/>--}}
            {{--<a href="{{ route('register') }}" class="util__mb">View Pricing, Terms &amp; Conditions</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row">
                <div class="col-md-6 text-center col-md-offset-3">
                    <a style="display:none;" href="{{ route('register') }}" class="btn btn-warning util__mb">Register</a><br/>
                    <a href="{{ route('pub.terms-and-conditions.index') }}"     class="util__mb">View Terms &amp; Conditions</a>
                </div>
            </div>--}}


        </div>
    </div>
	


            <!-- Modal -->
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

    <div class="map-grow">
        <div class="container">
           <div class="row text-center">
		   
		     
		      <div class="col-md-6 col-md-offset-3">
                 @if(isset($homePage) && !empty($homePage))
                        @if($homePage->footer != '')
                            @php echo html_entity_decode($homePage->footer); @endphp
                        @endif
                    @endif
					</div>
					
				
					
           </div>
        </div>
    </div>
    
    

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
<div class="container-fluid leading-industry-section">
<div class="row">
<div class="col-md-6 space-left">
<h2>Get the inside <br> scoop from <br> leading industry <br> professionals.</h2>
<button type="button" class="btn btn-warning util__mb--small text-uppercase btn-registerModal" data-toggle="modal" data-target="#registerModal">SIGN UP NOW</button>
</div>
<div class="col-md-6 pr-0">
<img src="{{url('/')}}/img/industry-img02.png">
</div>
</div>
</div> 
<div class="business-outer">
<div class="container-fluid">
<div class="row">
<div class="col-md-7 space-left">
<div class="render-logo">
<img src="{{url('/')}}/img/render-logo.png">
</div>
<h2>Render Makes Business <br>
Better For Everyone.</h2>
<div class="business-box">
<h5>Realtors Join <span class="badge">FREE!</span></h5>
<p>Reap the benefits of seamless connections <br> 
with lenders, as well as home buyers and sellers, <br> 
and watch your business thrive!</p>
</div>
<div class="business-box">
<h5>Lenders only pay <span class="badge">$29/mo.</span></h5>
<p>Engage with an exceptionally rich network of <br> 
realtors. Team up and generate more loans than ever!</p>
</div>
{{--
    <div class="business-box">
        <h5>Vendors! Only <span class="badge">$35/mo.</span></h5>
        <p>Get exclusive advertising and access to a stellar <br> 
        network of professionals for just $35 a month.</p>
    </div>
--}}
<button type="button" class="btn btn-warning util__mb--small text-uppercase btn-registerModal" data-toggle="modal" data-target="#registerModal">SIGN UP NOW</button>
</div>
<div class="col-md-5 business-img-box">
<img src="{{url('/')}}/img/art-0333.png">
</div>
</div>
</div>
</div>
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
