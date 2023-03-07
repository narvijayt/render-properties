@extends('layouts.app')

@section('title')
    {{ $user->full_name() }}'s Reviews
@endsection

@section('content')
        @component('pub.components.banner', ['banner_class' => 'connect'])
            {{$user->full_name()}}'s Reviews
        @endcomponent

        @foreach($reviews as $review)
            @include('pub.partials.reviews.reviews-results', ['review' => $review])
        @endforeach
@endsection