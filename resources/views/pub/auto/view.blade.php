@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')

@php $title = $user->first_name.' '.$user->last_name."'s Profile";  @endphp
@if($match)
    @php 
        $description = (isset($lendorView)) ? 'Real Broker Agent Details' : 'Loan Officer Details';
    @endphp
@else 
    @php 
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
  
    <style>.banner{margin:0}.footer{margin-top:0}</style> 
    @component('pub.components.banner', ['banner_class' => 'profile'])
		<h1 class="banner-title">{{$title}}</h1>
	@endcomponent
    <div class="container">
        <div class="row">
            @if(session()->has('message'))
                <div class="alert">
                    {{ session()->get('message') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif

            @if(isset($match))
                @if($user->user_type == 'broker')
                    <div class="col-md-12">
                        <div class="alert alert-success">Congratulations, you are now connected with {{ $user->first_name }}. To connect with your Loan Officer, now you can call or text the {{ $user->first_name }} at <a href="tel:{{ $user->phone_number }}">{{ $user->phone_number }}</a> or can send email at <a href="mailto:{{ $user->email }}">{{ $user->email }}</a> </div>
                    </div>
                @endif
            @endif

            <div class="col-md-3 @if ($user->designation !='' && $user->designation !='null') standard-agent @endif">
                <div class="profile-box-inner">
                    <div class="designation" style="display:none"><label>
                        @if($user->designation !="" && $user->designation !='null')
                            {{$user->designation}}
                        @endif 
                        </label>
                        <img src="{{ asset('img/ribben.png') }}">
                    </div>
                    <div class="user-profile__avatar-container">
                        <img src="{{$user->avatarUrl()}}" class="img-responsive user-profile__avatar" />
                    </div>
                    {{-- 
                        @if(!isset($match) && $user->user_type == 'broker' && (isset($realtorUser) && in_array($realtorUser->zip, explode(",", $user->zip))))
                            <div class="col-md-12 mt-3 text-center">
                                <form method="post" action="{{ route('create.automatch', ['brokerId' => $user->user_id, 'realtorId' => $realtorUser->user_id]) }}">
                                    {{ csrf_field() }}
                                    <button type="submit" name="create-auto-match" id="create-auto-match" class="btn btn-success">Connect with {{ $user->first_name }}</button>
                                </form>
                            </div>
                        @endif
                    --}}
                </div>
            </div>
            <div class="col-md-9">
                @include('pub.partials.users.user-profile-details')
            </div>
        </div>
    </div>

@endsection