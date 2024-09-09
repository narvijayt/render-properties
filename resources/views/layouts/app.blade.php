<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	

	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield('title', 'Default') | {{ config('app.name', 'Render') }}</title>
	<link rel="icon" href="/img/icon.png" sizes="32x32" type="image/png">
	@yield('meta')
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-touch-icon" href="/img/icon.png">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
		<!-- JWT Token -->
		<meta name="jwt-token" content="{{ JWTAuth::fromUser(Auth::user()) }}">
	@endauth
	 <!-- Styles -->
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100" rel="stylesheet">
		{{--<link href="{{ mix('css/app.css') }}" rel="stylesheet">--}}
		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	@if(url()->current() == 'https://www.render.properties')
		<style>/*.ad-for-desktop{display:none !important}*/</style>	
	@endif
	@if(Request::segment(1) === 'vendor-register' || Request::segment(1) === 'vendor-package-payment')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
	@endif
	@if(Request::segment(2) === 'detail')
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css" >
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!---<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js">	</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
	@endif
	@stack('styles-header')
	@stack('scripts-header')
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-74K9XE4F27"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-74K9XE4F27');
		</script>
		<link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">  

		<!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11006668907"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-11006668907'); </script>

		<script>
		!function (w, d, t) {
		w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};

		ttq.load('CMSO1DJC77U3EE0RKTNG');
		ttq.page();
		}(window, document, 'ttq');
		</script>
	</head>
	
	<body>
		
	@if(url()->current() == 'https://www.render.properties' || url()->current() == 'https://www.render.properties' || url()->current() == 'www.render.properties')
		<div id="app">
	@elseif(Request::segment(1) === 'about')
		<div id="app" class="editorpage">
	@elseif(Request::segment(1) === 'faq')
		<div id="app" class="editorpage">
	@elseif(Request::segment(1) === 'terms-and-conditions')
		<div id="app" class="editorpage">
	@elseif(Request::segment(1) === 'privacy-policy')
		<div id="app" class="editorpage">
	@else
		<div id="app">
	@endif

	@if(auth()->user() && (auth()->user()->mobile_verified == 0 || !auth()->user()->verified) )
		<div class="alert alert-dark-danger text-center radius-0" role="alert">
			@if(auth()->user()->mobile_verified == 0)
				<div class="d-block {{ (!auth()->user()->verified) ? 'mb-1' : '' }}">
					<strong>Your Phone Number is not verified.</strong> Please click on the button to verify your Phone Number
					<form action="{{ route('otp.sendnewotp', ['id' => auth()->user()->user_id]) }}" method="get" style="display: inline;">
						<button type="submit" class="btn btn-primary btn-sm">Verify Phone Number</button>
					</form>
				</div>
			@endif
			
			
			@if(!auth()->user()->verified)
				<div class="d-block">
					<strong>Please check your email inbox/spam to verify your email.</strong> If email didn't receive, please click on resend button
					<form action="{{ route('auth.resend-email-verification') }}" method="POST" style="display: inline;">
						{{ csrf_field() }}
						<button type="submit" class="btn btn-primary btn-sm">Resend Email</button>
					</form>
				</div>
			@endif
			
		</div>
	@endif


	@include('partials.nav')
	
	@yield('content')
	@include('partials.footer')
		<flash-messages :messages="{{ session('flash_notification', '[]') }}">
		</flash-messages>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" id="confirm-submit-modal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Confirm</h4>
				</div>
				<div class="modal-body">
					<p id="confirm-submit-modal-message">Are you sure?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
					<button type="button" class="btn btn-primary" id="confirm-submit-modal-accept" aria-label="Yes">Yes</button>
				</div>
			</div>
		</div>
	</div>
	@stack('modals')
	@auth
    	<script>
    		window.user = {!! auth()->user() !!}
    		// window.user = JSON.parse(u)
    		window.pusher_key = '{{ env('PUSHER_APP_KEY') }}'
    	</script>
	@endauth
	{{--<script src="{{ mix('js/app.js') }}"></script>--}}
	@if(Request::segment(2) != 'detail' && Request::segment(1) != 'vendor-register')
		<script src="{{ asset('/js/app.js') }}"></script>
	@endif
	@if(Request::segment(1) == 'profile' && Request::segment(2) == 'detail')
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
	@endif
		<script src="{{ asset('js/custom.js') }}"></script>
	@if(Request::segment(2) != 'detail' && Request::segment(1) != 'vendor-register')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
	@endif
	@if(Request::segment(1) != 'login')
		<script src="{{ asset('js/page-scripts/auth/partials/register-profile-form.js') }}"></script>
	@endif
		<script src="{{asset('js/card.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.js"></script>
	@stack('scripts-footer')
	</body>
</html>
