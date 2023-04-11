@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')
@section('title', 'Register')
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
        	<h1 class="banner-title">Register</h1>
    @endcomponent
	@if($_GET['type'] == 'consumer')
		<div class="blue-strip text-center">
			<div class="container">
				<h3> You’re One Step Away From Never Cold Calling  a Realtor Again. Gain Leverage You Have Never Had.  </h3>
			</div>
		</div>
	@endif
    <div class="container">
	    <div class="text-center">
		 
		 </div> 
		  
		 <div class="clearfix"></div><br>
		 <div class="row">
		     
		    <div class="col-md-12 register-info-heading {{ $registerType === 'lender' ? '' : 'hide' }}" data-info-type="lender">
                @include('partials.registration.lender-overview')
            </div>

            <div class="col-md-12 register-info-heading {{ $registerType === 'realtor' ? '' : 'hide' }}" data-info-type="realtor">
                @include('partials.registration.realtor-overview')
            </div>
            <div class="col-md-6">
               <!----  <div class="alert alert-success">During this time of crisis. Render stands with our members. Until further notice all membership monthly payments will be waived at this time.</div>-->
                 <div class="register-info {{ $registerType === 'realtor' ? '' : 'hide' }}" data-info-type="realtor">
                    @if(isset($realtorRegPage) && !empty($realtorRegPage))
                        @if($realtorRegPage->content != '')
                            @php echo html_entity_decode($realtorRegPage->content); @endphp
                        @endif
                    @endif
                </div>
                 <div class="register-info {{ $registerType === 'lender' ? '' : 'hide' }}" data-info-type="lender">
                    @if(isset($lenderRegPage) && !empty($lenderRegPage))
                        @if($lenderRegPage->content != '')
                            @php echo html_entity_decode($lenderRegPage->content); @endphp
                        @endif
                    @endif

                    {{--
                        <div class="register-info-left hide">
                            <h3>Call or Text <br> 704-569-5072 <br> for More Information</h3>
                            <ul>
                                <li><strong><span data-preserver-spaces="true">Members Connect with Match Exclusively with Productive Realtors.</span></strong></li>
                                <li><strong><span data-preserver-spaces="true">Gain access to our CRM that blasts the leads out to one loan officer and 5 agents at the same time. This ensures the loan officer is only working with the productive agent that claims the lead.</span></strong></li>
                                <li><strong><span data-preserver-spaces="true">The Realtor referrals, home buyer leads, the CRM on lead blast, and Richard Tocado's influence with EXP Realtors give you a complete mortgage purchase program.</span></strong></li>
                                <li><strong><span data-preserver-spaces="true">Register today to be connected by a {!! get_application_name() !!} rep for pricing and availability.</span></strong></li>
                            </ul>
                        </div>
                    --}}
                </div>
				
                <div class="col-md-12 {{ $registerType === 'realtor' ? '' : 'hide' }}" data-info-type="realtor">
                    @include('partials.svg.realtor-benefits-venn-diagram')
                </div>
                <div class="col-md-12 {{ $registerType === 'lender' ? '' : 'hide' }}" data-info-type="lender">
                    @include('partials.svg.lender-benefits-venn-diagram')
                </div>
			</div>
             
            <div class="col-md-6 register_form_outer">
         @if ($errors->has('error'))
              <div class="alert alert-danger">{{ $errors->first('error') }}</div>
            @endif
                @if($registerType === 'lender')
                    <form id="reg-form" role="form" method="POST" action="{{ url('/billing-information') }}">
                @elseif($registerType === 'consumer')
                    <form id="consumer-form" role="form" method="POST" action="{{ url('/consumer-register') }}">
                @else
                    <form id="reg-form" role="form" method="POST" action="{{ url('/register') }}">
                @endif
                    @if($registerType === 'consumer')
                        @include('auth.partials.consumer-register-form')
                    @else
                        @include('auth.partials.register-form')
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts-footer')
    <script>
    $(document).ready(function() {
    	var $checkboxes = $('.registration-info-switcher')
        var $infoBlocks = $('.register-info')

        $checkboxes.on('click', function(e) {
        	var activeType = $(this).data('info-switch')

            $infoBlocks.each(function() {
                if ($(this).data('info-type') == activeType) {
            		$(this).removeClass('hide')
                } else {
            		$(this).addClass('hide')
                }
            })
//            $checkboxes.addClass('hidden')
//            $(this).removeClass('hidden')
        })
    })
    </script>
@endpush
