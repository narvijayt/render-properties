@extends('layouts.app')
@section('title') {{ $user->full_name() }}'s Profile @endsection
@section('meta')
@php
    $description = $user->full_name().' Render profile'
@endphp

    {{ meta('description', $description) }}
    <?php 
if($user->user_type !="vendor"){
 $type = title_case($user->user_type === 'broker' ? 'Loan Officer' : 'real estate agent');?>
  {{ meta('keywords', $user->full_name().' Render profile,'.' Premium Member, '. $type) }}
<?php }else{
 $type = "Vendor";?>
 {{ meta('keywords', $user->full_name().' Render profile,'.' Premium Member, '. $type) }}
<?php } ?>
   {{ openGraph('og:title', $user->full_name().'\'s user profile') }}
    {{ openGraph('og:type', 'profile') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', $user->avatarUrl()) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', $user->full_name().'\'s user profile') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', $user->avatarUrl()) }}
    {{ googlePlus('name', $user->full_name().'\'s user profile') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', $user->avatarUrl()) }}
@endsection

<?php /** @var \App\User $user */ ?>
    @section('content')
    {{---- @if(count($findBanner)>0)
    @component('pub.components.premium_banner', ['banner_class' => 'premium','findBanner' =>$findBanner])
        <h1 class="banner-title">{{ $user->full_name() }}&#39s Profile</h1>
    @endcomponent
    @else
     @component('pub.components.banner', ['banner_class' => 'profile'])
        <h1 class="banner-title">{{ $user->full_name() }}&#39s Profile</h1>
    @endcomponent
    @endif ---}}
    
<!---==================== user-profile-hero =====================-->    
<div class="user-profile-hero">
  <!--- <div class="user-top-info" @if(count($findBanner) >0)style="background-image: url('{{asset('banner')}}/{{ $findBanner[0]->banner_image }}');" @endif>-->
<div class="user-top-info">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="user-profile__avatar-container">
                    <img src="{{$user->avatarUrl()}}" class="img-responsive user-profile__avatar" />
                </div>
            </div>
        <div class="col-md-9 user-top-right sss">
            <div class="row">
                <div class="col-md-4">
                    <h1 class="user-name">@if($user->full_name() !="") {{ $user->full_name() }} @endif </h1>
                    <h3 class="user-designation">@if($user->user_type !="vendor") {{ title_case($user->user_type === 'broker' ? 'lender' : 'real estate agent') }} @else Vendor @endif
                    </h3>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        @include('pub.partials.users.premium_users_sidebar')                  
                    </div>
                </div>
            </div>
            <div class="row">
            
                @if(Auth::user())
                    <div class="col-md-3 col-xs-6">  
                        @if($user->phone_number)
                            <i class="fa fa-mobile" aria-hidden="true"></i> 
                            <a class="text-white" href="tel:{{$user->phone_number}}">{{ $user->phone_number }}</a> 
                        @endif 
                    </div>
                @else
                    <div class="col-md-4 col-xs-6">  
                        <i class="fa fa-mobile" aria-hidden="true"></i> 
                        <a class="text-white" href="{{ route('login') }}">Login to view contact details</a> 
                    </div>
                @endif 
            
            
                @if(Auth::user())
                    <div class="col-md-9 col-xs-6 "> 
                        @if($user->email !="")
                            <i class="fa fa-envelope" aria-hidden="true"></i> 
                            <a class="text-white" href="mailto:{{$user->email}}">{{ $user->email }}</a>
                        @endif
                    </div>
                @else
                    <div class="col-md-8 col-xs-6">
                        <i class="fa fa-envelope" aria-hidden="true"></i> 
                        <a class="text-white" href="{{ route('login') }}">Login to view contact details</a> 
                    </div>
                @endif 
            
            </div>
        </div>
     </div>
    </div>
</div>  
    <div class="user-bottom-info">
        <div class="container">
            <div class="row">
            <div class="col-md-2 col-md-offset-3 user-phone-number">
                @if($user->city !="") 
                    <i class="fa fa-map-marker"></i>
                    {{ $user->city }}, {{ $user->state }}
                @endif
            </div>
            <div class="col-md-3">
                @if($user->firm_name !="") 
                    <i class="fa fa-building" aria-hidden="true"></i>
                    {{ $user->firm_name }} 
                @endif
            </div>
            <div class="col-md-4">           
                @if($user->website)
                    <i class="fa fa-globe" aria-hidden="true"></i> <a href="{{ real_url($user->website) }}" target="_blank">
                    {{ $user->website }}
                </a>
                @endif   
            </div>
            </div>
        </div>
    </div>
</div>  
    <!---==================== user-profile-hero END =====================-->
<div class="container">
    @include('pub.partials.users.premium_users_profile_info')
    
    @if(!empty($userSocialReviews))
        <div class="row">
            <div class="col-md-12">
    			@include('pub.partials.users.socialreviews.socail-reviews')
    		</div>
        </div>
    @endif
</div>
@endsection
@push('modals')
<div class="modal fade" id="reportUserProfileModal" tabindex="-1" role="dialog" aria-labelledby="reportUserProfileModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pub.user.report', $user) }}" method="POST">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
            <h4 class="modal-title" id="myModalLabel">Report {{ $user->first_name }}'s Profile</h4>
            </div>
                <div class="modal-body">
                    <p>All reports of violations within user profiles will be reviewed by admins.</p>
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('report') ? 'has-error' : '' }}">
                        <label class="control-label" for="report">
                            @if($errors->has('report'))
                                <i class="fa fa-times-circle-o"></i>
                            @endif 
                        Report
                        </label>
                        <textarea type="text" class="form-control" placeholder="Why are you reporting {{ $user->first_name }}'s profile?" name="report" rows="3">{{old('report')}}</textarea>
                            @if($errors->has('report'))
                            <span class="help-block">
                                {{ $errors->first('report') }}
                            </span>
                            @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush
@push('modals')
<div class="modal fade" id="blockUserModal" tabindex="-1" role="dialog" aria-labelledby="blockUserModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pub.user.block', $user) }}" method="POST">
            {{ csrf_field() }}
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
            <h4 class="modal-title" id="myModalLabel">Block {{ $user->first_name }}</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you wish to block {{ $user->first_name }}</p>
                <div class="form-group {{ $errors->has('reason') ? 'has-error' : '' }}">
                <label class="control-label" for="reason">
                @if($errors->has('reason'))
                    <i class="fa fa-times-circle-o"></i>
                @endif
                 Reason
                </label>
                <textarea type="text" class="form-control" placeholder="Why are you reasoning {{ $user->first_name }}'s profile?" name="reason" rows="3">
                    {{old('reason')}}
                </textarea>
                @if($errors->has('reason'))
                    <span class="help-block">
                        {{ $errors->first('reason') }}
                    </span>
                @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('modals')
<div class="modal fade" id="reviewUserModal" tabindex="-1" role="dialog" aria-labelledby="reviewUserModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pub.reviews.create') }}" method="POST">
                {{ csrf_field() }}
                <input class="hidden" id="user_id" name="user_id" value="{{$user->user_id}}"/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Review {{ $user->first_name }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('reviewRating') ? 'has-error' : '' }}">
                        <label class="control-label" for="reviewRating">
                            @if($errors->has('reviewRating'))
                                <i class="fa fa-times-circle-o"></i>
                            @endif 
                        Rating
                        </label>
                        <select class="form-control" id="reviewRating" name="reviewRating">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group {{ $errors->has('reviewMessage') ? 'has-error' : '' }}">
                        <label class="control-label" for="reviewMessage">
                            @if($errors->has('reviewMessage'))
                                <i class="fa fa-times-circle-o"></i>
                            @endif 
                            Review Message
                        </label>
                        <textarea type="text" class="form-control" placeholder="Please Write your review of {{$user->first_name.' '.$user->last_name}} here" name="reviewMessage" rows="3">{{old('reviewMessage')}}</textarea>
                        @if($errors->has('reviewMessage'))
                            <span class="help-block">{{ $errors->first('reviewMessage') }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush


