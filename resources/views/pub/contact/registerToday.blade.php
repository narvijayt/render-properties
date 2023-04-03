@extends('layouts.app')
@section('title') Registration @endsection
@section('meta')
@if(!empty($regMeta) && !is_null($regMeta))
@if(!is_null($regMeta->description))
{{ meta('description',html_entity_decode(strip_tags($regMeta->description))) }}
@else
{{ meta('description','Registration on Render') }}
@endif
@if(!is_null($regMeta->keyword))
{{ meta('keywords',html_entity_decode(strip_tags($regMeta->keyword))) }}
@else
{{ meta('keywords', config('seo.keyword')) }}
@endif
@else
{{ meta('description','Registration on Render') }}
{{ meta('keywords', config('seo.keyword')) }}
@endif
    @php
        $description = 'Registration on Render'
    @endphp
    {{ openGraph('og:title', 'Registration on Render') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Registration on Render') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Registration on Render') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection
@section('content')

    @component('pub.components.banner', ['banner_class' => 'contact'])
        <h1 class="banner-title">Registration on {!! get_application_name() !!}!</h1>
    @endcomponent
    <div class="container">
        <div class="row">
            @if(isset($regPage) && !empty($regPage))
                @if($regPage->header != '')
                    @php echo html_entity_decode($regPage->header); @endphp
                @endif
            @endif
        </div>
         <br/>
     <div class="row ">
            @if(isset($regPage) && !empty($regPage))
                @if($regPage->content != '')
                    @php echo html_entity_decode($regPage->content); @endphp
                @endif
            @endif
        </div>
        <br/>
    <div class="clearfix"></div>
        <div class="row">
            @if(isset($regPage) && !empty($regPage))
                @if($regPage->content != '')
                    @php echo html_entity_decode($regPage->footer); @endphp
                @endif
            @endif
        </div>
    </div>
@endsection
