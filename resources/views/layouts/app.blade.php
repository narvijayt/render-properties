<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    <!-- Google Tag Manager -->
	<script>
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','{{ config('google.tagmanager.key') }}');
	</script>
		<!-- End Google Tag Manager -->
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
		<!-- Place the following in the HEAD before BODY tag -->
		<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
		<script>
			var googletag = googletag || {};
			googletag.cmd = googletag.cmd || [];
		</script>
		<script>
		googletag.cmd.push(function() {
			googletag.defineSlot('/21803544343/RBC-HP', [300, 600], 'div-gpt-ad-1552396650444-0').addService(googletag.pubads());
			googletag.pubads().enableSingleRequest();
			googletag.pubads().collapseEmptyDivs();
			googletag.enableServices();
		});
		</script>
		<script>
		googletag.cmd.push(function() {
			googletag.defineSlot('/21803544343/RBC-LL1', [970, 90], 'div-gpt-ad-1552396960512-0').addService(googletag.pubads());
			googletag.pubads().enableSingleRequest();
			googletag.pubads().collapseEmptyDivs();
			googletag.enableServices();
		});
		</script>
	<script>
		googletag.cmd.push(function() {
			googletag.defineSlot('/21803544343/RBC-LR1', [336, 280], 'div-gpt-ad-1552397044238-0').addService(googletag.pubads());
			googletag.pubads().enableSingleRequest();
			googletag.pubads().collapseEmptyDivs();
			googletag.enableServices();
		});
		</script>
		<script>
		googletag.cmd.push(function() {
			googletag.defineSlot('/21803544343/RBC-LB1', [728, 90], 'div-gpt-ad-1552397119304-0').addService(googletag.pubads());
			googletag.pubads().enableSingleRequest();
			googletag.pubads().collapseEmptyDivs();
			googletag.enableServices();
		});
		</script>
		<script>
		googletag.cmd.push(function() {
			googletag.defineSlot('/21803544343/RBC-MR1', [300, 250], 'div-gpt-ad-1552397962554-0').addService(googletag.pubads());
			googletag.pubads().enableSingleRequest();
			googletag.pubads().collapseEmptyDivs();
			googletag.enableServices();
		});
		</script>
		<script>
			googletag.cmd.push(function() {
				googletag.defineSlot('/21803544343/RBC-MB1', [320, 50], 'div-gpt-ad-1552397818666-0').addService(googletag.pubads());
				googletag.pubads().enableSingleRequest();
				googletag.pubads().collapseEmptyDivs();
				googletag.enableServices();
			});
		</script>
	@if(url()->current() == 'https://www.render.properties')
		<!-- Conversion Pixel for [misc]- DO NOT MODIFY -->
		<img style="display:none;" src="https://data.adxcel-ec2.com/pixel/?ad_log=referer&action=misc&pixid=6ebfe037-db9d-4717-bb0b-4bb3c4d8e135" width="1" height="1" border="0">
		<!-- End of Conversion Pixel -->
	@elseif(Request::segment(1) === 'contact')
		<!-- Conversion Pixel for [content]- DO NOT MODIFY -->
		<img style="display:none;" src="https://data.adxcel-ec2.com/pixel/?ad_log=referer&action=content&pixid=6ebfe037-db9d-4717-bb0b-4bb3c4d8e135" width="1" height="1" border="0">
		<!-- End of Conversion Pixel -->
	@elseif(Request::segment(1) === 'search-profiles')
		<!-- Conversion Pixel for [registration]- DO NOT MODIFY -->
		<img style="display:none;" src="https://data.adxcel-ec2.com/pixel/?ad_log=referer&action=registration&pixid=6ebfe037-db9d-4717-bb0b-4bb3c4d8e135" width="1" height="1" border="0">
		<!-- End of Conversion Pixel -->
	@elseif(isset($_GET['type']) && $_GET['type'] === 'realtor')   
		<!-- Conversion Pixel for [signup]- DO NOT MODIFY -->
		<img style="display:none;" src="https://data.adxcel-ec2.com/pixel/?ad_log=referer&action=signup&pixid=6ebfe037-db9d-4717-bb0b-4bb3c4d8e135" width="1" height="1" border="0">
		<!-- End of Conversion Pixel -->
	@elseif(isset($_GET['type']) && $_GET['type'] === 'lender')  
		<!-- Conversion Pixel for [lead]- DO NOT MODIFY -->
		<img style="display:none;" src="https://data.adxcel-ec2.com/pixel/?ad_log=referer&action=lead&pixid=6ebfe037-db9d-4717-bb0b-4bb3c4d8e135" width="1" height="1" border="0">
		<!-- End of Conversion Pixel -->
	@endif
		<link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">  
	</head>
	
	<body>
		<!-- Google Tag Manager (noscript) -->
		<noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id={{ config('google.tagmanager.key') }}" height="0" width="0" style="display:none;visibility:hidden">
		</iframe>
	</noscript>
	<!-- End Google Tag Manager (noscript) -->
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-6901510063192256",
			enable_page_level_ads: true
		});
	</script>
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
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('google.analytics.key') }}"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', '{{ config('google.analytics.key') }}');
		</script>
		<script type="text/javascript">
			window.__lc = window.__lc || {};
			window.__lc.license = 11648588;
			(function() {
				var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
				lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
			})();
		</script>
		<noscript>
			<a href="https://www.livechatinc.com/chat-with/11648588/" rel="nofollow">Chat with us</a>,
			powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a>
		</noscript>
	</body>
</html>
