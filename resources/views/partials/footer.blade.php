<div class="footer footer-light">
    <div class="container">
        <div class="row">
		  <div class="col-md-4 col-sm-3  col-xs-12">
			 <a href="{{ route('home') }}" class="footer__brand">
                    {{--@include('partials.svg.rbc-logo-dark-background')--}}
                    <img src="{{url('/')}}/img/render-properties-logo.png">
                </a>
			</div>
		<div class=" col-md-8 col-sm-9 col-xs-12 footer-flex">
		<div class="footer_social">
		<ul>
		<li class="fb-join_footer"> <a href="{{ config('app.social_links.joinfb') }}" target="_blank" class="header__social-link"><i aria-hidden="true" class="fa fa-facebook"></i><span>Join Group</span></a></li>
		<li>
	 <a href="{{ config('app.social_links.facebook') }}" target="_blank" class="footer__social-link"><i aria-hidden="true" class="fa fa-facebook"></i></a>
	 </li>
	 </ul>
		</div>
		 <div class="collapse navbar-collapse" id="realbroker-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('home') }}" class="">Home</a></li>
                <li><a href="javascript:void(0)" style="display: block;" data-toggle="modal" data-target="#myModal1" class="">Search Profiles</a></li>
                <!----<li><a href="{{ route('pub.contact.advertise') }}"   class="">Advertise</a></li>-->
                {{--<li><a href="{{ url('vendor-register') }}"   class="">Advertise</a></li>--}}
                
                <li class="dropdown dropdown-top">
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
                    <li class="dropdown dropdown-top-01">
					 <a href="#" class="dropdown-toggle navbar__button navbar__button--register" data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false">Register <span class="caret"></span></a>
					 <ul class="dropdown-menu">					     
							<li><a href="{{ route('register', [ 'type' => 'realtor' ]) }}"  class="navbar__button navbar__button--register">as a Real Estate Agent</a></li>
							<li><a href="{{ route('register', [ 'type' => 'lender' ]) }}"  class="navbar__button navbar__button--register">as a Loan Officer</a></li>
							{{--<li><a href="{{ url('vendor-register') }}"  class="navbar__button navbar__button--register">as a Vendor</a></li>--}}
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
		</div>
		  
            <!---- <div class="col-sm-8">
                <ul class="footer__nav">
                    <li class="footer__nav-item"><a href="{{ route('pub.about.index') }}" class="footer__nav-link">About</a></li>
                    <li class="footer__nav-item"><a href="{{ route('pub.faq.index') }}" class="footer__nav-link">FAQ</a></li>
                    {{--<li class="footer__nav-item"><a href="https://agentsandhomebuyers.com/" class="footer__nav-link">Real Estate Leads</a></li>--}}
                    <li class="footer__nav-item"><a href="{{ route('pub.terms-and-conditions.index') }}" class="footer__nav-link">Terms &amp; Conditions</a></li>
                    <li class="footer__nav-item"><a href="{{ route('pub.privacy-policy.index') }}" class="footer__nav-link">Privacy Policy</a></li>
                    <li class="footer__nav-item"><a href="{{ route('pub.contact.index') }}" class="footer__nav-link">Contact</a></li>
                </ul>
                <div class="footer__social-container">
                    <a href="{{ config('app.social_links.facebook') }}" target="_blank" class="footer__social-link"><span class="fa fa-facebook"></span></a>
					
					<a href="https://www.twitter.com/realbrokerconn" class="footer__social-link" target="_blank"><span class="fa fa-twitter"></span></a>
                       
                    <a href="https://www.instagram.com/realbrokerconnection/" class="footer__social-link" target="_blank"><span class="fa fa-instagram"></span></a>
					
                    <a href="https://www.youtube.com/channel/UCN8jQpQD8OaM2tv9QCSLqEQ" class="footer__social-link" target="_blank"><span class="fa fa-youtube"></span></a>
					
                    <a href="{{ config('app.social_links.linkedin') }}" target="_blank" class="footer__social-link" ><span class="fa fa-linkedin"></span></a>
					
                    <a href="https://www.pinterest.com/realbrokerconnection/" class="footer__social-link" target="_blank"><span class="fa fa-pinterest"></span></a>
					
                    <a target="_blank" href="https://www.tumblr.com/blog/realbrokerconnection" class="footer__social-link"><span class="fa fa-tumblr"></span></a>
					
                    <a target="_blank" href="https://vimeo.com/channels/realbrokerconnection" class="footer__social-link"><span class="fa fa-vimeo"></span></a>
                </div>
            </div>
            <div class="col-sm-4" class="footer__copyright-container">
                <a href="{{ route('home') }}" class="footer__brand">
                    {{--@include('partials.svg.rbc-logo-dark-background')--}}
                    <img src="{{url('/')}}/img/logo-2.jpg">
                </a>
                <p class="footer__copyright">&copy;{{ \Carbon\Carbon::now()->format('Y') }} Render. All Rights Reserved.</p>
            </div> ---->
        </div>
    </div>
</div>
