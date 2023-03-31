@extends('layouts.app')
@if(Auth::user())
	@php $user_name = $user->full_name(); @endphp
@else
	@php $user_name = $user->first_name; @endphp
@endif

@section('title') {{ $user_name }}'s Profile @endsection
@section('meta')
	@php
		$description = $user_name.' Render profile'
	@endphp
	{{ meta('description', $description) }}
	   <?php 
    if($user->user_type !="vendor"){
      $type = title_case($user->user_type === 'broker' ? 'Lender' : 'real estate agent');
      if($user->designation !='' && $user->designation !='null' && $user->user_type  === "realtor"){?>
         {{ meta('keywords', $user_name.' Render profile,'.' Unpaid Member, '. $type .', Standard Gold Agent') }}
        <?php } ?>
      
      {{ meta('keywords', $user_name.' Render profile,'.' Unpaid Member, '. $type) }}
    <?php }else{
     $type = "Vendor";?>
    {{ meta('keywords', $user_name.' Render profile,'.' Premium Member, '. $type) }}
    <?php } ?>

	{{ openGraph('og:title', $user_name.'\'s user profile') }}
	{{ openGraph('og:type', 'profile') }}
	{{ openGraph('og:url', Request::url()) }}
	{{ openGraph('og:image', $user->avatarUrl()) }}
	{{ openGraph('og:description', $description) }}
	{{ openGraph('og:site_name', config('app.name')) }}
	{{ openGraph('fb:admins', config('seo.facebook_id')) }}
	{{ twitter('twitter:card', 'summary') }}
	{{ twitter('twitter:title', $user_name.'\'s user profile') }}
	{{ twitter('twitter:site', config('seo.twitter_handle')) }}
	{{ twitter('twitter:description', $description) }}
	{{ twitter('twitter:creator', config('seo.twitter_handle')) }}
	{{ twitter('twitter:image', $user->avatarUrl()) }}
	{{ googlePlus('name', $user_name.'\'s user profile') }}
	{{ googlePlus('description', $description) }}
	{{ googlePlus('image', $user->avatarUrl()) }}
@endsection
<?php /** @var \App\User $user */ ?>
@section('content')
	@component('pub.components.banner', ['banner_class' => 'profile'])
		<h1 class="banner-title">{{ $user_name }}&#39s Profile</h1>
	@endcomponent
    <div class="container user-profile-view">
        <div class="row">
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
                    @include('pub.partials.users.sidebar-actions')
                    --}}
                </div>
            </div>
            <div class="col-md-9">
                @include('pub.partials.users.user-profile-details')
            </div>
            
            @if(!empty($userSocialReviews))
                <div class="col-md-12">
                    @include('pub.partials.users.socialreviews.socail-reviews')
                </div>
            @endif
        </div>
    </div>
@endsection
@push('modals')
<div class="modal fade" id="reportUserProfileModal" tabindex="-1" role="dialog" aria-labelledby="reportUserProfileModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="{{ route('pub.user.report', $user) }}" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Report {{ $user->first_name }}'s Profile</h4>
				</div>
				<div class="modal-body">
					<p>All reports of violations within user profiles will be reviewed by admins.</p>
					{{ csrf_field() }}
					<div class="form-group {{ $errors->has('report') ? 'has-error' : '' }}">
						<label class="control-label" for="report">
						@if($errors->has('report'))<i class="fa fa-times-circle-o"></i>@endif Report
						</label>
						<textarea type="text" class="form-control" placeholder="Why are you reporting {{ $user->first_name }}'s profile?" name="report" rows="3">{{old('report')}}</textarea>
						@if($errors->has('report'))
							<span class="help-block">{{ $errors->first('report') }}</span>
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
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Block {{ $user->first_name }}</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you wish to block {{ $user->first_name }}</p>
					<div class="form-group {{ $errors->has('reason') ? 'has-error' : '' }}">
						<label class="control-label" for="reason">
						@if($errors->has('reason'))<i class="fa fa-times-circle-o"></i>@endif Reason
						</label>
						<textarea type="text" class="form-control" placeholder="Why are you reasoning {{ $user->first_name }}'s profile?" name="reason" rows="3">{{old('reason')}}</textarea>
						@if($errors->has('reason'))
							<span class="help-block">{{ $errors->first('reason') }}</span>
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
					@endif Rating
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
						@endif Review Message
					</label>
					<textarea type="text" class="form-control" placeholder="Please Write your review of {{$user->first_name.' '.$user->last_name}} here" name="reviewMessage" rows="3">{{
					old('reviewMessage')}}</textarea>
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


