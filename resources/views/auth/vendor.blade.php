@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')
@section('title', 'Vendor Register')
@section('meta')
@php
$description = 'Register for Render'
@endphp
{{ meta('description', $description) }}
{{ meta('keywords', 'Vendor Registration, Render') }}

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
{{--@component('pub.components.banner', ['banner_class' => 'lender'])
        <h1 class="banner-title">Register</h1>
@endcomponent--}}

<div class="vendor-top-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-6">
                {!! $getVendorRegisterPage->banner !!}
            </div>
            <div class="col-md-7  col-sm-6">
            </div>
        </div>
    </div>
</div>

<section class="streamlined-outer">

    <div class="container">

        <!--- <div class="col-md-3"></div>
		 <div class="col-md-6 alert alert-success">During this time of crisis. Render stands with our members. Until further notice all membership monthly payments will be waived at this time.</div>
		 	 <div class="col-md-3"></div>---->

        <div class="row realtor-row ">
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <form id="vendor_registers" class="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
               <div class=" row realtor-row">
                <div class="col-md-7 number-list-box-left">
                    {!! $getVendorRegisterPage->section_1_Header !!}

                    <div class="mt-2"></div>
                    @if (isset($getVendorRegisterPage->section_1))
                        @php
                            $section1Array = (array) json_decode($getVendorRegisterPage->section_1, true);
                            $counter = 1;
                        @endphp

                        @if (!empty(section1Array))
                            @foreach ($section1Array as $key => $value)
                                <div class="number-list-box mb-2">
                                    <div class="number-box">
                                        <h3 class="m-0">{{ $counter++ }}</h3>
                                    </div>
                                    <div class="streamlined-text">
                                        {!! $value !!}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                    @endif
                    
                    <div class="per-month-price">
                        <h3 class="text-white mt-0 text-uppercase">{{ $optionLabel }}</h3>
                    </div>
                    <div class="sign-up-link">
                        <a class="text-orange" href="javascript:;">SIGN UP NOW <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-md-5 realtor-register_form_outer vendor-register_form_outer">
                    @include('partials.registration.vendor-register')
                </div>
            </div>
            </form>
        </div>
    </div>
</section>
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
						
					<div class="carousel-control-box">
					<a class="carousel-control left carousel-control-prev" href="#testimoniial-slider"
                            data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>

                        <a class="carousel-control right carousel-control-next" href="#testimoniial-slider"
                            data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
					</div>
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
                 </div>
                    @endif
                    <div class="sign-up-link">
                        <a class="text-orange" href="#">SIGN UP NOW <i class="fa fa-arrow-right"
                                aria-hidden="true"></i></a>
                    </div>
                </div>

            </div>
            <div class="col-md-5">
            </div>
        </div>
    </div>
</div>

<div class="start-deals-outer serve-outer py-3">
    <div class="container p-0">
        <div class="row">
            <div class="col-md-7">
                <h2 class="text-left h1 text-white  mb-1 mt-0">Who’s It For?</h2>
                <p class="text-white text-left">Here’s just a small sample of the types of vendors we serve.</p>
                <div class="col-md-12 p-0 ">
                    <div class="text-left vendors-serve-box mt-1">
                        <div class="vendors-serve-image-box">
                            <img src="/img/edit-document-icon.png">
                        </div>
                        <div class="vendors-serve-text-box">
                            <p class="text-white"><b>Home Inspectors <br> Appraisers <br> Title Companies <br> Home
                                    Warranty Companies <br> Insurance Agents <br> Escrow Agents <br> Real Estate
                                    Attorneys</b></p>
                        </div>
                    </div>
                    <div class="text-left vendors-serve-box mt-1">
                        <div class="vendors-serve-image-box">
                            <img src="/img/construction-icon-02.png">
                        </div>
                        <div class="vendors-serve-text-box">
                            <p class="text-white"><b>Moving Companies <br> Contractors & Renovation Specialists <br>
                                    Pest Control Services <br> Environmental Consultants <br> Utility Service Providers
                                    <br> Smart Home Automation Vendors</b></p>
                        </div>
                    </div>
                    <div class="text-left vendors-serve-box mt-1">
                        <div class="vendors-serve-image-box">
                            <img src="/img/design-services-icon.png">
                        </div>
                        <div class="vendors-serve-text-box">
                            <p class="text-white"><b>Home Stagers & Interior Designers <br> Landscaping Services <br>
                                    Photographers & Videographers</b></p>
                        </div>

                    </div>
                    <div class="sign-up-link text-left vendors-up-link">
                        <a class="text-orange" href="#">SIGN UP NOW <i class="fa fa-arrow-right"
                                aria-hidden="true"></i></a>
                    </div>

                </div>
            </div>
            <div class="col-md-5">
            </div>
        </div>
    </div>
</div>

<div class="start-deals-outer estate-jobs py-3">
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
                        <img src="/img/connect-icon-new-02.png">
                        <h3 class="text-orange mb-0">2.</h3>
                        <p class="text-white"><b>Connect with agents, lenders, <br> & other real <br> estate pros</b>
                        </p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="/img/close-deal-icon-03.png">
                        <h3 class="text-orange mb-0">3.</h3>
                        <p class="text-white"><b>See the jobs <br> come to you</b></p>
                    </div>
                    <div class="sign-up-link text-center">
                        <a class="text-orange" href="#">SIGN UP NOW <i class="fa fa-arrow-right"
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
            <div class="col-md-12 center-box text-left">
                <div class="col-md-3">
                    <img src="{{url('/')}}/img/richard-image-home.png">
                </div>
                <div class="col-md-9 instant-text">
                {!! $getVendorRegisterPage->section_2 !!}
                    <div class="sign-up-link text-left mt-1">
                        <a class="text-primary" href="#">SIGN UP NOW <i class="fa fa-arrow-right"
                                aria-hidden="true"></i></a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts-footer')

@endpush