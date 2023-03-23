<br/><br/>
<div class="user-profile__send-message-container">
	@if($user->website)
		@if($user->user_type == 'realtor')
				<a href="{{ real_url($user->website) }}" target="_blank">
					<button class="btn btn-warning btn-block">Search for Homes</button>
				</a>
			@else
				<a href="{{ real_url($user->website) }}" target="_blank">
					<button class="btn btn-warning btn-block">Get Pre-Approved</button>
				</a>
			@endif
	@endif
</div>
@auth
    <div class="user-profile__send-message-container">
			@if($user->user_id != Auth::user()->user_id)
				<send-message :recipient="{{ $user }}"></send-message>
			@endif
	</div>
    @php
		/** @var \App\User $authUser */
		$authUser = auth()->user();
	@endphp
	@if($authUser->isMatchedWith($user))
		<div class="user-profile__send-message-container">
			<a class="btn btn-warning btn-block" href="sms:{{$user->phone_number}}">Send SMS</a>
		</div>

		@if($user->user_type !="vendor" && auth()->user()->user_type != 'vendor')
			<a class="btn btn-warning btn-block" href="{{ route('pub.profile.matches.index') }}">
			Manage Matches</a>
			<div class="text-center util__mb--large">
				<a href="{{ route('pub.faq.index') }}#match" class="small text-info" target="_blank">
				What is a Match?</a>
			</div>
		@endif
	@endif
	{{---@can('requestMatch', $user)---}}
	@if($user->user_type !="vendor" && auth()->user()->user_type != 'vendor' && !$authUser->isMatchedWith($user) && $user->user_type != auth()->user()->user_type )
         @if($user->user_type == 'realtor')
		<div>
			<form action="{{ route('pub.matches.request-match', $user) }}" method="POST">
				{{ csrf_field() }}
				<button type="submit" class="btn btn-warning btn-block">Request Match</button>
				<div class="text-center util__mb--large">
					<a href="{{ route('pub.faq.index') }}#match" class="small text-info" target="_blank">
						What is a Match?
					</a>
				</div>
			</form>
		</div>
		@endif
		@if($user->user_type == 'broker' && $user->created_at <='2020-01-01 00:00:00')
		<div>
			<form action="{{ route('pub.matches.request-match', $user) }}" method="POST">
				{{ csrf_field() }}
				<button type="submit" class="btn btn-warning btn-block">Request Match</button>
				<div class="text-center util__mb--large">
					<a href="{{ route('pub.faq.index') }}#match" class="small text-info" target="_blank">
						What is a Match?
					</a>
				</div>
			</form>
		</div>
		@endif
	@endif
	{{----@endcan ----}}
@endauth

