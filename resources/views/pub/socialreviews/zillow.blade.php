@extends('layouts.app')

@section('title')
    {{ $socialReviews->screenname }}'s Reviews
@endsection

@section('content')
    @component('pub.components.banner', ['banner_class' => 'connect'])
       {{ $socialReviews->screenname }}'s Reviews
    @endcomponent
    @foreach($socialReviews->proReviews->review as $review)
        @include('pub.partials.socialreviews.reviews-results', ['review' => $review])
    @endforeach
@endsection