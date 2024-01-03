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
{{--- @component('pub.components.banner', ['banner_class' => 'lender'])
<h1 class="banner-title">Register</h1>
@endcomponent --}}

<div class="top-inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h1 class="m-0">REALTOR SIGN UP</h1>
                <h2 class="mt-1 h1 mb-0">Close Fast & <br> Scale Your Business</h2>
                <p class="text-primary mb-0 pl-5"><b>Closing deals is now easier than ever with our free network of
                        lenders and vendors. Elevate your real estate game today.</b></p>
            </div>
            <div class="col-md-7 ">
            </div>
        </div>
    </div>
</div>
<div id="streamlined-outer-scroll" class="streamlined-outer">
    <div class="container">
        <div class="row realtor-row">
            {{-- <div class="col-md-12 " data-info-type="realtor">
            @include('partials.registration.realtor-overview')
	</div> --}}
            <div class="col-md-7 number-list-box-left">
                <h2 class="text-left text-white h2  pb-1 mt-0">A Streamlined Social Network, <br> Just For Real Estate
                    Pros</h2>
                <p class="text-left text-white">With Render, you’ll get access to pre-approved lenders and <br> real
                    estate vendors in your area.</p>
                <div class="number-list-box mb-2 mt-2">
                    <div class="number-box">
                        <h3 class="m-0">1</h3>
                    </div>
                    <div class="streamlined-text">
                        <h4 class="text-orange m-0">Speed to Sale:</h4>
                        <p class="text-white">Don’t waste any more time searching for and Lenders and Vendors. Get
                            immediate connections to people like, home inspectors, appraisers, and legal pros; people
                            who Render has vetted and checked out to make sure there the best</p>
                    </div>
                </div>

                <div class="number-list-box mb-2">
                    <div class="number-box">
                        <h3 class="m-0">2</h3>
                    </div>
                    <div class="streamlined-text">
                        <h4 class="text-orange m-0">Diverse Lenders with Tailored Products:</h4>
                        <p class="text-white">Get access to a host of different lenders with a variety of offerings.
                            From traditional lending, to non-QM, to down payment programs; get hand-tailored lending
                            products that fit your client’s unique needs.</p>
                    </div>
                </div>


                <div class="number-list-box mb-2">
                    <div class="number-box">
                        <h3 class="m-0">3</h3>
                    </div>
                    <div class="streamlined-text">
                        <h4 class="text-orange m-0">Free Marketing:</h4>
                        <p class="text-white">Besides the referrals you’ll get from your Render network, we also market
                            your services for free. We advertise your profile page on all major social media platforms.
                        </p>
                    </div>
                </div>
                <div class="sign-up-link">
                    <a class="text-orange" href="#streamlined-outer-scroll">SIGN UP FOR FREE <i class="fa fa-arrow-right"
                            aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-md-5 ">
                <!----  <div class="alert alert-success">During this time of crisis. Render stands with our members. Until further notice all membership monthly payments will be waived at this time.</div>-->
                <div class="register-info" data-info-type="realtor">
                    @if(isset($realtorRegPage) && !empty($realtorRegPage))
                        @if($realtorRegPage->content != '')
                            @php echo html_entity_decode($realtorRegPage->content); @endphp
                        @endif
                    @endif
                </div>

                <div class="col-md-12" data-info-type="realtor">
                    @include('partials.svg.realtor-benefits-venn-diagram')
                </div>
            </div>

            <div class="col-md-5 realtor-register_form_outer ">
                @if ($errors->has('error'))
                <div class="alert alert-danger">{{ $errors->first('error') }}</div>
                @endif
                <form id="reg-form" role="form" method="POST" action="{{ url('/register') }}">
                    @include('auth.partials.register-form')
                </form>
            </div>
        </div>
    </div>
</div>
<div class="testimonials-outer light-gray-bg py-3">
    <div class="container p-0">
        <div class="row">
            <div class="col-md-7 testimonials-left">
                <h2 class="text-left h1  mb-1 mt-0">Testimonials</h2>

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

                        <a class="carousel-control left carousel-control-prev" href="#testimoniial-slider"
                            data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>

                        <a class="carousel-control right carousel-control-next" href="#testimoniial-slider"
                            data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                @endif
                <div class="sign-up-link">
                    <a class="text-orange" href="#streamlined-outer-scroll">SIGN UP FOR FREE <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>

            </div>
            <div class="col-md-5">
            </div>
        </div>
    </div>
</div>

<div class="start-deals-outer py-3">
    <div class="container p-0">
        <div class="row">
            <div class="col-md-7">
                <h2 class="text-center h1 text-white  mb-1 mt-0">Start Closing More Deals</h2>
                <div class="col-md-12 start-deals-box ">
                    <div class="col-md-4 text-center">
                        <img src="/img/sign-up-icon-2.png">
                        <h3 class="text-orange mb-0">1.</h3>
                        <p class="text-white"><b>Sign Up</b></p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="/img/close-deal-icon-03.png">
                        <h3 class="text-orange mb-0">2.</h3>
                        <p class="text-white"><b>Connect <br> with lenders <br> & vendors</b></p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="/img/connect-icon-new-02.png">
                        <h3 class="text-orange mb-0">3.</h3>
                        <p class="text-white"><b>See your <br> deals close at <br> light speed</b></p>
                    </div>
                    <div class="sign-up-link text-center">
                        <a class="text-orange" href="#streamlined-outer-scroll">SIGN UP NOW <i class="fa fa-arrow-right"
                                aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
            </div>
        </div>
    </div>
</div>

<div class="instant-access-outer">
    <div class="container pb-0">
        <div class="row ">
            <div class="center-box text-left">
                <div class="col-md-3">
                    <img src="{{url('/')}}/img/richard-image-home.png">
                </div>
                <div class="col-md-9 instant-text">
                    <h2 class="text-left h1  mb-1 mt-0">Get Instant Access To <br> 1,000s Of Real Estate Pros, <br>
                        Nationwide!</h2>

                    <p class="text-primary">Render was created by The Carolinas leading mortgage and Real Estate broker
                        Richard Tocado, with a little help from Jimmy Kelly. To boost his own business, Richard wound up
                        creating the largest network of realtors and lenders in the country. Now, they’re bringing this
                        powerful network to you. </p>
                    <p class="text-primary">No more cold-calling. </p>
                    <p class="text-primary">No more hours of searching for the pros.</p>
                    <p class="text-primary">No more incompetent real estate pros.</p>
                    <p class="text-primary">And you get access to talent nationwide.Sign up now and see what the Render
                        network can do for you.</p>
                    <div class="sign-up-link text-left mt-1">
                        <a class="text-primary" href="#streamlined-outer-scroll">SIGN UP FOR FREE <i class="fa fa-arrow-right"
                                aria-hidden="true"></i></a>
                    </div>

                </div>
            </div>
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