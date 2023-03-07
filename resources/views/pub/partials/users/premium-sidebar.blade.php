@auth
 @if($user->website !="")
                <div class="col-md-4 col-xs-6 text-center">
                <a href="{{ real_url($user->website) }}" target="_blank">
                <button class="btn btn-warning btn-block">Get Pre-Approved</button>
                </a>
                </div>
				@endif
				<div class="col-md-4 col-xs-6 text-center">
            @if($user->user_id != Auth::user()->user_id)
                <send-message :recipient="{{ $user }}"></send-message>
            @endif
        </div>
    @php
        /** @var \App\User $authUser */
        $authUser = auth()->user();
    @endphp
    @if($authUser->isMatchedWith($user))
    @if($user->user_type !="vendor" && auth()->user()->user_type != 'vendor')
        <div class="col-md-4 col-xs-6 text-center">
            <a class="btn btn-warning btn-xs" href="{{ route('pub.profile.matches.index') }}">Manage Matches</a>
            <a href="{{ route('pub.faq.index') }}#match" class="small text-white" target="_blank">What is a Match?</a>
        </div>
        @endif
    @endif
    @can('requestMatch', $user)
    @if($user->user_type !="vendor" && auth()->user()->user_type != 'vendor')
    <div class="col-md-4 col-xs-6 text-center">
        <form action="{{ route('pub.matches.request-match', $user) }}" method="POST">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-warning btn-xs">Request Match</button>
            <a href="{{ route('pub.faq.index') }}#match" class="small text-white" target="_blank">What is a Match?</a>
        </form>
    </div>
    @endif
    @endcan
@endauth

