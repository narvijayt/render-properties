<nav class="navbar navbar-fixed-top">
    <div class="container">
	<div class="top-header-section">
	<div class="header-contact">
	<ul>
	<li class="fb-join"> <a href="{{ config('app.social_links.joinfb') }}" target="_blank" class="header__social-link"><i aria-hidden="true" class="fa fa-facebook"></i><span>Join Group</span></a>
	</li>
	<li class="fb_link"><a href="{{ config('app.social_links.facebook') }}" target="_blank" class="footer__social-link"><i aria-hidden="true" class="fa fa-facebook"></i></a></li>
	<!--<li>
	<a class="header__social-link" href="javascript:;" onClick="window.open('{{ config('app.social_links.facebook') }}','pagename','resizable,height=500,width=500, margin: 0 auto,'); return false;"><i aria-hidden="true" class="fa fa-facebook"></i><span>Join Group</span></a>
	</li>-->
	<li class="mobile-hide">
	<a href="{{ route('pub.contact.index') }}" class="contact-btn">CONTACT US</a>
	</li>
	<li>
	<div class="call-text">CALL OR TEXT</div>
	</li>
	</ul>
	<div class="header-number"><a href="tel:7045695072">704.569.5072</a></div>
	</div>
	</div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#realbroker-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ route('home') }}" class="navbar-brand">
                {{--@include('partials.svg.rbc-logo-light-background')--}}
                {{--<img src="/img/tocado_logo.png" alt="Render Logo" />--}}
                {{--
                @if()
                    <img src="{{url('/')}}/img/render-logo.png">
                @else
                    <img src="{{url('/')}}/img/logo-02.png">
                @endif
                --}}
                <img src="{{url('/')}}/img/logo-full.png">
            </a>
			
        </div>
        <div class="collapse navbar-collapse" id="realbroker-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('home') }}" class="">Home</a></li>
                <li><a href="javascript:void(0)" style="display: block;" data-toggle="modal" data-target="#myModal1" class="">Search Profiles</a></li>
                <!----<li><a href="{{ route('pub.contact.advertise') }}"   class="">Advertise</a></li>-->
                {{--<li><a href="{{ url('vendor-register') }}"   class="">Advertise</a></li>--}}
                
                <li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false">Blog <span class="caret"></span></a>
					<ul class="dropdown-menu">					     
						<li><a href="{{ route('lendersBlogListing') }}">Mortgage Blog</a></li>
						<li><a href="{{ route('agentsBlogListing') }}">Real Estate Blog</a></li>
				    </ul>
			    </li>
			    
                <li><a href="{{ route('pub.contact.index') }}"   class="">Contact</a></li>
                @guest
                    <li><a href="{{ url('/login') }}" class="navbar__button navbar__button--login" role="button">Login</a></li>
                    {{--<li><a href="{{ route('register') }}" class="navbar__button navbar__button--register">Register</a></li>--}}
                    <li class="dropdown">
					 <a href="#" class="dropdown-toggle navbar__button navbar__button--register" data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false">Register <span class="caret"></span></a>
					 <ul class="dropdown-menu">					     
							<li><a href="{{ route('register', [ 'type' => 'realtor' ]) }}"  class="navbar__button navbar__button--register">as a Real Estate Agent</a></li>
							<li><a href="{{ route('register', [ 'type' => 'lender' ]) }}"  class="navbar__button navbar__button--register">as a Loan Officer</a></li>
							{{-- <li><a href="{{ url('vendor-register') }}"  class="navbar__button navbar__button--register">as a Vendor</a></li> --}}
					    </ul>
					    </li>
                @endguest

                @auth
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle navbar__profile-dropdown"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false">
                        <img src="{{ auth()->user()->avatarUrl(\App\Enums\AvatarSizeEnum::SMALL) }}" class="navbar__avatar"/>
                        {{ auth()->user()->full_name() }} <span class="badge badge-brand" style="background-color:red;">@if(auth()->user()->notificationCount() > 0 ) {{ auth()->user()->notificationCount() }} @endif</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">

                        <li><a href="{{ route('pub.profile.index') }}"  >Profile</a></li>
                         @if(auth()->user()->user_type != 'vendor')
                        <li><a href="{{ route('pub.profile.matches.index') }}">Manage Matches <span class="badge badge-brand" style="background-color:red;">@if(auth()->user()->pendingMatchCount() > 0 ){{ auth()->user()->pendingMatchCount() }} @endif</span></a></li>
                        @endif
                        <li><a href="{{ route('pub.message-center.index') }}">Message Center <span class="badge badge-brand" style="background-color:red;">@if(auth()->user()->unread_message_count() > 0 ){{ auth()->user()->unread_message_count() }} @endif</span></a></li>
                        
                        @can('manage-payment', \App\User::class)
                        <!-- <li><a href="{{ route('pub.profile.payment.plans') }}"  >Billing Info</a></li> -->
                        @endcan
                          @if(auth()->user()->user_type == 'vendor' && auth()->user()->braintree_id !="")
                            <!-- <li><a href="{{ route('pub.profile.payment.plans') }}"  >Billing Info</a></li> -->
                            @endif
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </div> <!-- /.container -->
</nav>
<!-- Modal -->
<div id="myModal1" class="modal fade searching-popup" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&#10005;</button>
              <div class="modal-body text-center">
        	       <div class="row"> 
            	       <div class="col-md-6"> 	       
            				  <a href="{{url('search-realtor-profiles')}}">		   
            				  <img src="{{url('/')}}/img/Real-Estate-Agent-icon.png">
            				 <button type="button" class="btn btn-primary btn-block btn-md">Search Realtors</button>
            				 </a>
            		    </div>
            		    <div class="col-md-6"> 	
            				 <a href="{{url('search-lender-profiles')}}">
            					<img src="{{url('/')}}/img/Lender-icon.png">
            				 <button type="button" class="btn btn-primary btn-block btn-md">Search Lenders</button>
            				 </a>
        		        </div>
        		        {{--
        		        <div class="col-md-4"> 	
            				 <a href="{{url('search-vendor')}}">
            					<img src="{{url('/')}}/img/seller.png">
            				 <button type="button" class="btn btn-primary btn-block btn-md">Search Vendors</button>
            				 </a>
        		        </div>
        		        --}}
        		  </div>
              </div>
        </div>
    </div>
</div>
