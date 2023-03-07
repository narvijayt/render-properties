@extends('layouts.app')
@section('title') Frequently Asked Questions @endsection
@section('meta')
@if(!empty($faqMeta) && !is_null($faqMeta))
@if(!is_null($faqMeta->description))
{{ meta('description',html_entity_decode(strip_tags($faqMeta->description)))}}
@else
{{ meta('description','Frequently Asked Questions about Render') }}
@endif
@if(!is_null($faqMeta->keyword))
{{ meta('keyword',html_entity_decode(strip_tags($faqMeta->keyword))) }}
@else
{{ meta('keyword', config('seo.keyword')) }}
@endif
@else
{{ meta('description','Frequently Asked Questions about Render') }}
{{ meta('keyword', config('seo.keyword')) }}
@endif
     @php
        $description = 'Frequently Asked Questions about Render'
    @endphp
    {{ openGraph('og:title', 'Frequently Asked Questions') }}
    {{ openGraph('og:type', 'article') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Frequently Asked Questions') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Frequently Asked Questions') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')

    @component('pub.components.banner', ['banner_class' => 'faq'])
        @if(isset($faqPage) && !empty($faqPage))
            @if($faqPage->header != '')
                @php echo html_entity_decode($faqPage->header); @endphp
            @else
                Frequently Asked Questions
            @endif
        @endif
    @endcomponent
    @if(isset($faqPage) && !empty($faqPage))
        @if($faqPage->content != '')
            @php echo html_entity_decode($faqPage->content); @endphp
        @else
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <p>
                            <strong>Why is this site different from other sites?</strong><br/>
                            The real estate agents are vetted and want to be contacted by a lender.
                        </p>
                        <p>
                            <strong>What is the best way to use this site?</strong><br/>
                            Be active and reach out to the agents right away to let them know you're a new lender on the site and excited to build a relationship.
                        </p>
                        <p>
                            <strong id="match">What is a match?</strong><br/>
                            A match is when a Realtor and Loan Officer agree that they are a great fit and they both want to work together. As a loan officer when you match with a Realtor and the Realtor matches with you the Realtor disappears from the site and no other loan officer will have access to the Realtor. As a loan officer you will still have access to all the other Realtors on the site and have the option of matching with more Realtors and having the Realtors disappear from the site. The more Realtors you match with the more that will be out of reach for all the other loan officers.
                        </p>
                        <p>
                            <strong>How does the review process work?</strong><br/>
                            Each lender and real estate agent is asked to review their experience with each other. Negative reviews are given the chance to respond and explain the situation.
                        </p>
                        <p>
                            <strong>Do you provide leads for both mortgages and real estate deals?</strong><br/>
                            We sell mortgage leads only to ensure compliance.
                        </p>
                        {{--<p>--}}
                        {{--<strong>How does the leads system work?</strong><br/>--}}
                        {{--The leads are sold state wide and at a min. of $1,000.00 for 40 leads ($25 each) They are exclusive to each lender forever.--}}
                        {{--</p>--}}
                        {{--<p>--}}
                        {{--<strong>Is there a referral fee for agents who get business from this site?</strong><br/>--}}
                        {{--Yes, a referral fee is paid to Richard Tocado Companies. Please review our Referral Contract.--}}
                        {{--</p>--}}
                        <p>
                            ​<strong>Is there a yearly contract?</strong><br/>
                            No, but you can save 17% by paying annually.
                        </p>
                        <p>
                            <strong>How do I cancel my membership?</strong><br/>
                            Call {{ config('app.support_phone') }} or <a href="{{ route('pub.contact.index') }}">email us</a>
                        </p>
                        <p>
                            <strong>Can I contact members directly?</strong><br/>
                            Yes. Once you're a member you can contact other members directly.
                        </p>
                        <p>
                            <strong>Can I have more than one profile?</strong><br/>
                            No
                        </p>
                        <p>
                            <strong>Is my privacy protected?</strong><br/>
                            Yes
                        </p>
                        <p>
                            <strong>Will I get spam from your company?</strong><br/>
                            No
                        </p>
                    </div>
					
					
					<div class="col-md-4">
								<!-- /21803544343/RBC-HP -->
									<div id='div-gpt-ad-1552396650444-0' style='height:600px; width:300px;'>
									<script>
									googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552396650444-0'); });
									</script>
									</div>
									
									<div class="clearfix"></div><br>
									
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
@endsection