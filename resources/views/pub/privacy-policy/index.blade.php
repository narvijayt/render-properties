@extends('layouts.app')
@section('title') Privacy Policy @endsection
@section('meta')
@if(!empty($privacyMeta) && !is_null($privacyMeta))
@if(!is_null($privacyMeta->description))
{{ meta('description',html_entity_decode(strip_tags($privacyMeta->description))) }}
@else
{{ meta('description','Render Privacy Policy') }}
@endif
@if(!is_null($privacyMeta->keyword))
{{ meta('keywords',html_entity_decode(strip_tags($privacyMeta->keyword))) }}
@else
{{ meta('keywords', config('seo.keyword')) }}
@endif
@else
{{ meta('description','Render Privacy Policy') }}
{{ meta('keywords', config('seo.keyword')) }}
@endif
    @php
        $description = 'Render Privacy Policy'
    @endphp
    {{ openGraph('og:title', 'Privacy Policy') }}
    {{ openGraph('og:type', 'article') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Privacy Policy') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Privacy Policy') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')


    @component('pub.components.banner', ['banner_class' => 'terms-and-conditions'])
        @if(isset($privacyPage) && !empty($privacyPage))
            @if($privacyPage->header != '')
                <h1 class="banner-title"> <?php echo html_entity_decode($privacyPage->header);?></h1>
            @else
                <h1 class="banner-title">Privacy Policy</h1>
            @endif
        @endif
    @endcomponent
    @if(isset($privacyPage) && !empty($privacyPage))
        @if($privacyPage->content != '')
            @php echo html_entity_decode($privacyPage->content); @endphp
        @else
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <strong>
                                Your privacy is very important to us. Accordingly, we have developed this Policy in order for you to understand how we collect, use, communicate and disclose and make use of personal information. The following outlines our privacy policy.
                            </strong>
                        </p>
                        <ul>
                            <li>Before or at the time of collecting personal information, we will identify the purposes for which information is being collected.</li>
                            <li>We will collect and use of personal information solely with the objective of fulfilling those purposes specified by us and for other compatible purposes, unless we obtain the consent of the individual concerned or as required by law.</li>
                            <li>We will only retain personal information as long as necessary for the fulfillment of those purposes.</li>
                            <li>We will collect personal information by lawful and fair means and, where appropriate, with the knowledge or consent of the individual concerned.</li>
                            <li>Personal data should be relevant to the purposes for which it is to be used, and, to the extent necessary for those purposes, should be accurate, complete, and up-to-date.</li>
                            <li>We will protect personal information by reasonable security safeguards against loss or theft, as well as unauthorized access, disclosure, copying, use or modification.</li>
                            <li>We will make readily available to customers information about our policies and practices relating to the management of personal information.</li>
                            <li>We are committed to conducting our business in accordance with these principles in order to ensure that the confidentiality of personal information is protected and maintained.</li>
                        </ul>

                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection