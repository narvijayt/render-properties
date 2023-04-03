@extends('layouts.app')
@section('title') About Us @endsection
@section('meta')
@if(!empty($aboutMeta) && !is_null($aboutMeta))
@if(!is_null($aboutMeta->description))
{{ meta('description',html_entity_decode(strip_tags($aboutMeta->description))) }}
@else
{{ meta('description','About Render') }}
@endif
@if(!is_null($aboutMeta->keyword))
{{ meta('keywords',html_entity_decode(strip_tags($aboutMeta->keyword))) }}
@else
{{ meta('keywords', config('seo.keyword')) }}
@endif
@else
{{ meta('description','About Render') }}
{{ meta('keywords', config('seo.keyword')) }}
@endif
     @php
        $description = 'About Render'
    @endphp
    {{ openGraph('og:title', 'About Us') }}
    {{ openGraph('og:type', 'article') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'About Us') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'About Us') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')
    @component('pub.components.banner', ['banner_class' => 'about-us'])
        @if(isset($aboutPage) && !empty($aboutPage))
            @if($aboutPage->header != '')
                <h1 class="banner-title"><?php echo html_entity_decode($aboutPage->header);?>
            @else
                <h1 class="banner-title">About Us</h1>
            @endif
        @endif
    @endcomponent

    @if(isset($aboutPage) && !empty($aboutPage))
        @if($aboutPage->content != '')
            @php echo html_entity_decode($aboutPage->content); @endphp
        @else
            <div class="container mission">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="text-center util__section-header">Mission</h2>
                        <p class="top_buffer">
                            <strong>Welcome to {!! get_application_name() !!}, where we believe the "solution" is the connection.</strong> After several years in both the mortgage and real estate business we found that it was difficult and time consuming finding other professionals with the same goals. We learned that there is a need for Mortgage and Real Estate Professionals to have a source to come together, exchange ideas and build productive partnerships. This site does just that!
                        </p>
                        <p>
                            Mortgage Lenders are able to search and find active buyer agents looking to build new lender partnerships. Real Estate Agents are able to search and find lenders that specialize in the purchase market, and provide the products and service to cater to their clients needs. Additionally, both Lenders and Real Estate Agents receive 30 days free coaching and additional online marketing presence.
                        </p>
                    </div>
					<div class="col-md-4">
					     	<!-- /21803544343/RBC-MR1 -->
									<div id='div-gpt-ad-1552397962554-0' style='height:250px; width:300px;'>
									<script>
									googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552397962554-0'); });
									</script>
									</div>
					
					   </div>
                </div>
            </div>
        @endif
    @endif

    @if(isset($aboutPage) && !empty($aboutPage))
        @if($aboutPage->footer != '')
            @php {{--echo html_entity_decode($aboutPage->footer);--}}  @endphp
        @else
            <div class="team">
                <div class="container">
                    <div class="row top_buffer">
                        <h2 class="text-center util__section-header">Leadership Team</h2>
                        <div class="col-md-4">
                            <img src="img/richard.jpg" class="img-responsive center-block" />
                        </div>
                        <div class="col-md-8">
                            <strong>Richard Tocado</strong><br/>
                            Founder, {!! get_application_name() !!}
                            ​
                            <ul>
                                <li>President and Founder of the Richard Tocado Companies</li>
                                <li>Experience in both the mortgage and real estate business since 1999</li>
                                <li>Widely recognized in the industry as one of the top mortgage and real estate marketers and relationship builders in the US</li>
                                <li>Closed thousands of transactions</li>
                                <li>Stellar record with A+ rating from Better Business Bureau</li>
                                <li>Active member of the community through media exposure, NASCAR endorsements and other avenues</li>
                            </ul>
                        </div>
                        {{--<div class="col-md-2 logos">--}}
                        {{--<a href="http://homewithrichard.com/"><img src="img/rt_logo_1.jpg" class="img-responsive center-block" /></a><br/>--}}
                        {{--<a href="http://mortgageleads411.com/"><img src="img/go_fast.jpg" class="img-responsive center-block" /></a><br/>--}}
                        {{--<a href="http://tocado.kwrealty.com/"><img src="img/rt_logo_2.jpg" class="img-responsive center-block" /></a>--}}
                        {{--</div>--}}
                    </div>

                    {{--<div class="row">--}}
                    {{--<div class="col-md-12 hr">--}}
                    {{--&nbsp;--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="row">--}}
                    {{--<div class="col-md-3 text-center">--}}
                    {{--<img src='img/person1.jpg' class='img-responsive center-block' /><br/>--}}
                    {{--<strong>Name</strong><br/>--}}
                    {{--Title<br/>--}}
                    {{--Role<br/>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-1">&nbsp;</div>--}}
                    {{--<div class="col-md-3 text-center">--}}
                    {{--<img src='img/person2.jpg' class='img-responsive center-block' /><br/>--}}
                    {{--<strong>Name</strong><br/>--}}
                    {{--Title<br/>--}}
                    {{--Role<br/>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-1">&nbsp;</div>--}}
                    {{--<div class="col-md-3 text-center">--}}
                    {{--<img src='img/person3.jpg' class='img-responsive center-block' /><br/>--}}
                    {{--<strong>Name</strong><br/>--}}
                    {{--Title<br/>--}}
                    {{--Role<br/>--}}
                    {{--</div>--}}

                    {{--</div>--}}
                </div>
            </div>
        @endif
    @endif
@endsection