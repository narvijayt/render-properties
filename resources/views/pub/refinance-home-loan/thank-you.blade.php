@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends("layouts.app")
@section('title', 'Thank You - Render')
@section('meta')
@if(!empty($meta))
@if(!is_null($meta->description))
{{ meta('description',html_entity_decode(strip_tags($meta->description))) }}
@else
{{ meta('description', config('seo.description')) }}
@endif
@if(!is_null($meta->keywords))
{{ meta('keywords', html_entity_decode(strip_tags($meta->keyword)))}}
@else
{{ meta('keywords', config('seo.keyword')) }}
@endif
@else
{{ meta('description', config('seo.description')) }}
{{ meta('keywords', config('seo.keyword')) }}
@endif
{{ openGraph('og:title', 'Home') }}
{{ openGraph('og:type', 'product') }}
{{ openGraph('og:url', Request::url()) }}
{{ openGraph('og:image', config('seo.image')) }}
{{ openGraph('og:description', config('seo.description')) }}
{{ openGraph('og:site_name', config('app.name')) }}
{{ openGraph('fb:admins', config('seo.facebook_id')) }}
{{ twitter('twitter:card', 'summary') }}
{{ twitter('twitter:site', config('seo.twitter_handle')) }}
{{ twitter('twitter:title', 'Home') }}
{{ twitter('twitter:description', config('seo.description')) }}
{{ twitter('twitter:creator', config('seo.twitter_handle')) }}
{{ twitter('twitter:image', config('seo.image')) }}
{{ googlePlus('name', 'Home') }}
{{ googlePlus('description', config('seo.description')) }}
{{ googlePlus('image', config('seo.image')) }}
@endsection

@section("content")
<!-- Banner -->
<div class="banner privacy">
    <div class="container">
        <h1 class="banner-title"> Thank You!</h1>
    </div>
</div>

<!-- Form -->
<div class="row">
    <div class="card property-form-outer property-Step-form">

        <div class="container form-header">
            @if(session()->has('success'))
                <div class="mb-1">
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
                </div>
            @endif
            
            @if(session()->has('error'))
                <div class="mb-1">
                    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
                </div>
            @endif
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="container p-3 mb-3">
                <div class="multi-step-form text-center thankyou-msg">
                    <i class="fa fa-check check-icon"></i>
                    <h4 class="text-center">We have received your inquiry and are currently reviewing your information. One of our experts will follow up shortly to provide a personalized one-on-one consultation.</h4>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection