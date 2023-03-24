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
    @component('pub.components.banner', ['banner_class' => 'profile'])
        {{$title}}
    @endcomponent
  
    <style>.banner{margin:0}.footer{margin-top:0}</style> 
    <section class="py-2">
        <div class="container">
            <div class="row text-dark user-profile">
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

                    <div class="row open-profile-details">
                        <div class="col-md-12">
                            <div class="col-sm-6 col-md-4">
                                <i class="fa fa-phone-square"></i> <a href="tel:{{ $user->phone_number}}"> {{ $user->phone_number }}</a>
                            </div>
                            <div class="col-sm-6 col-md-4 hide-desktop">
                                <i class="fa fa-wechat"></i> <a href="sms:{{ $user->phone_number}}"> Send SMS </a>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <i class="fa fa-envelope"></i> <a href="mailto:{{ $user->email}}"> {{ $user->email }}</a>
                            </div>
                        </div>
                    </div>
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
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Contact Info</h4>
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Profession:</strong>
                                    {{ $user->user_type == 'broker' ? 'lender' : 'real estate agent' }}
                                </li>
                                <li><strong>Name:</strong>{{ $user->full_name() }}</li>
                                @if($user->firm_name)
                                <li><strong>Company:</strong>{{ $user->firm_name }}</li>
                                @endif
                                <li><strong>City:</strong>{{ $user->city }}</li>
                                <li><strong>State:</strong>{{ $user->state }}</li>
                                <li>
                                    <strong>Email:</strong>
                                    @if(isset($match))
                                        <a href="mailto:{{$user->email}}">
                                            {{ $user->email }}
                                        </a>
                                    @else
                                        <a class="text-link" href="javascript:;">Connect with {{ $user->first_name}} to see the details.</a> 
                                    @endif
                                </li>
                                
                                @if($user->phone_number)
                                <li><strong>Phone Number:</strong>
                                    @if(isset($match))
                                        <a class="text-link" href="tel:{{ $user->phone_number }}">{{ $user->phone_number }}</a>
                                        @if ($user->phone_ext)
                                            Ext: {{ $user->phone_ext }}
                                        @endif
                                    @else
                                        <a class="text-link" href="javascript:;">Connect with {{ $user->first_name}} to see the details.</a> 
                                    @endif
                                </li>
                                @endif
                                
                                @if($user->website)
                                <li>
                                    <strong>Website links:</strong>
                                    <a href="{{ real_url($user->website) }}" target="_blank">{{ $user->website }}</a>
                                </li>
                                @endif
                            </ul>
                            <div class="clearfix"></div>
                            
                            <h4>Experience</h4>
                            <ul class="list-unstyled">
                                @if(isset($user->license))
                                    <li><strong>License#:</strong>
                                    {{$user->license}}
                                    </li>
                                @endif
                                @if(isset($user->specialties))
                                    <li><strong>Specialties:</strong>
                                    {{ $user->specialties }}
                                    </li>
                                @endif
                                @if($user->user_type !="broker")
                                @if(isset($user->units_closed_monthly))
                                    <li><strong>Number of units closed monthly:</strong>
                                    {{ $user->units_closed_monthly }}
                                    </li>
                                @endif
                                @if(isset($user->volume_closed_monthly))
                                    <li><strong>Average volume closed monthly:</strong>
                                    {{ $user->volume_closed_monthly }}
                                    </li>
                                @endif
                                @endif
                                <li><strong>Areas/Locations served:</strong>
                                {{ $user->city }}, {{ $user->state }}
                                </li>
                            </ul>
                        </div>    


                        
                        @if($user->bio!= '')
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><strong>Biographical information:</strong>{{ $user->bio }}</li>
                            </ul>
                        </div>
                        @endif

                        @if(!isset($match) && $user->user_type == 'broker')
                            <div class="col-md-12">
                                <form method="post" action="{{ route('create.automatch', ['brokerId' => $user->user_id, 'realtorId' => $realtorUser->user_id]) }}">
                                    {{ csrf_field() }}
                                    <button type="submit" name="create-auto-match" id="create-auto-match" class="btn btn-success">Connect with {{ $user->first_name }}</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection