@extends('layouts.app')
@section('title') Advertise @endsection
@section('meta')
@if(!empty($advMeta) && !is_null($advMeta))
@if(!is_null($advMeta->description))
{{ meta('description',html_entity_decode(strip_tags($advMeta->description))) }}
@else
{{ meta('description','Advertise on Render') }}
@endif
@if(!is_null($advMeta->keyword))
{{ meta('keywords',html_entity_decode(strip_tags($advMeta->keyword))) }}
@else
{{ meta('keywords', config('seo.keyword')) }}
@endif
@else
{{ meta('description','Advertise on Render') }}
{{ meta('keyword', config('seo.keyword')) }}
@endif
@php
        $description = 'Advertise on Render'
    @endphp
    {{ openGraph('og:title', 'Advertise on Render') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Advertise on Render') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Advertise on Render') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')

    @component('pub.components.banner', ['banner_class' => 'contact'])
        <h1 class="banner-title">Advertise on Render!</h1>
    @endcomponent

    <div class="container">
        <div class="row top-buffer">
            @if(isset($advPage) && !empty($advPage))
                @if($advPage->content != '')
                    @php echo html_entity_decode($advPage->content); @endphp
                @endif
            @endif
        </div>
    </div>
@endsection
