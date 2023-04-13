<div class="col-md-3 col-xs-6 text-center mb-1 @if ($user->designation !="" && $user->designation !='null') standard-agent @else @if ($user->billing_first_name !="") paid_member @else unpaid_member @endif @endif">
    <div class="profile-box-inner">
	 <div class="designation" style="display:none"><label>@if($user->designation !="" && $user->designation !="null"){{$user->designation}}@endif </label> <img src="{{ asset('img/ribben.png') }}"></div>
        <img src="{{ $user->avatarUrl() }}" class="search-result__avatar"/>
        <h4 class="mb-0 pb-0">
		<a href="{{ route('pub.user.show', $user->user_id) }}">{{ $user->first_name }}</a> {!! user_verified_badge($user->user_id) !!}</h4>
         @if($user->state !="") <p><i class="fa fa-map-marker"></i> @if($user->city !=""){{ $user->city }},@endif {{ $user->state }}</p>@endif
        <p><a href="{{ route('pub.user.show', $user->user_id) }}" class="btn btn-warning search-result__profile-link">View Profile</a></p>
      </div>
    </div>
    