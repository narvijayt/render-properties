@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')

@if($match)
    @php 
        $title = (isset($lendorView)) ? 'Real Broker Agent Details' : 'Loan Officer Details';
        $description = (isset($lendorView)) ? 'Real Broker Agent Details' : 'Loan Officer Details';
    @endphp
@else 
    @php 
        $title = 'Confirm Match'; 
        $description = 'Create a Match with Loan Officer';
    @endphp
@endif

@section('title', $title)
@section('meta')
    {{ meta('description', $description) }}
    {{ meta('keywords', config('seo.keyword')) }}
    {{ openGraph('og:title', $title) }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}

    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', $title) }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}

    {{ googlePlus('name', 'Register') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection
@section('content')
    @component('pub.components.banner', ['banner_class' => 'lender'])
        {{$title}}
    @endcomponent
  
    <style>.banner{margin:0}.footer{margin-top:0}</style> 
    <section class="py-2">
        <div class="container">
            <div class="row text-dark">
                @if(session()->has('message'))
                    <div class="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                @if(isset($lendorView))
                <div class="col-md-8 col-md-offset-2">
                        <h4>Real Estate Details</h4>
                        <div class="col-md-12">
                            <strong class="col-md-6">Name:</strong>
                            <p class="col-md-6">{{ $realtorUser->first_name.' '.$realtorUser->last_name}}</p>
                        </div>
                        <div class="col-md-12">
                            <strong class="col-md-6">Email:</strong>
                            <p class="col-md-6">{{ $realtorUser->email }}</p>
                        </div>

                        @if(isset($match))
                            <div class="col-md-12">
                                <strong class="col-md-6">Phone:</strong>
                                <p class="col-md-6">{{ $realtorUser->phone_number }}</p>
                            </div>
                            <div class="col-md-12">
                                <strong class="col-md-6">Match Status</strong>
                                <p class="col-md-6">{{ $match->accepted_at1 != '' ? 'Connected' : 'Pending' }}</p>
                            </div>
                        @endif

                        @if(!isset($match))
                            <form method="post" action="{{ route('create.automatch', ['brokerId' => $brokerUser->user_id, 'realtorId' => $realtorUser->user_id]) }}">
                                {{ csrf_field() }}
                                <button type="submit" name="create-auto-match" id="create-auto-match" class="btn btn-success">Create Match</button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="col-md-8 col-md-offset-2">
                        <h4>Broker Details</h4>
                        <div class="col-md-12">
                            <strong class="col-md-6">Name:</strong>
                            <p class="col-md-6">{{ $brokerUser->first_name.' '.$brokerUser->last_name}}</p>
                        </div>
                        <div class="col-md-12">
                            <strong class="col-md-6">Email:</strong>
                            <p class="col-md-6">{{ $brokerUser->email }}</p>
                        </div>

                        @if(isset($match))
                            <div class="col-md-12">
                                <strong class="col-md-6">Phone:</strong>
                                <p class="col-md-6">{{ $brokerUser->phone_number }}</p>
                            </div>
                            <div class="col-md-12">
                                <strong class="col-md-6">Match Status</strong>
                                <p class="col-md-6">{{ $match->accepted_at2 != '' ? 'Connected' : 'Pending' }}</p>
                            </div>
                        @endif

                        @if(!isset($match))
                            <form method="post" action="{{ route('create.automatch', ['brokerId' => $brokerUser->user_id, 'realtorId' => $realtorUser->user_id]) }}">
                                {{ csrf_field() }}
                                <button type="submit" name="create-auto-match" id="create-auto-match" class="btn btn-success">Create Match</button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection