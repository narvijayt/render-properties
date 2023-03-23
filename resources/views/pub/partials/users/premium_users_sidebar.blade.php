<br/><br/>
@if($user->website)
    @if($user->user_type == 'realtor')
            <div class="col-md-6 col-xs-6 text-center">
                <a href="{{ real_url($user->website) }}" target="_blank">
                    <button class="btn btn-warning btn-block">Search for Homes</button>
                </a>
            </div>
        @else
            <div class="col-md-6 col-xs-6 text-center">
                <a href="{{ real_url($user->website) }}" target="_blank">
                    <button class="btn btn-warning btn-block">Get Pre-Approved</button>
                </a>
            </div>
          
    @endif
@endif
@auth
    <div class="col-md-6 col-xs-6 text-center">
        @if($user->user_id != Auth::user()->user_id)
            <send-message :recipient="{{ $user }}"></send-message>
        @endif
    </div>

    @php
        /** @var \App\User $authUser */
        $authUser = auth()->user();
    @endphp

    @if($authUser->isMatchedWith($user))
        <div class="col-md-6 col-xs-6 text-center">
            <a class="btn btn-warning btn-block" href="sms:{{$user->phone_number}}">Send SMS</a>
        </div>

        @if($user->user_type !="vendor" && auth()->user()->user_type != 'vendor')
        <div class="col-md-6 col-xs-6 text-center">
            <a class="btn btn-warning btn-block" href="{{ route('pub.profile.matches.index') }}">Manage Matches</a>
            <div class="text-center util__mb--large">
                <a href="{{ route('pub.faq.index') }}#match" class="small text-info" target="_blank">What is a Match?</a>
            </div>
        </div>
        @endif
    @endif
    @can('requestMatch', $user)
        @if($user->user_type !="vendor" && auth()->user()->user_type != 'vendor' && (in_array( $authUser->zip, explode(",", $user->zip))) )
            <div class="col-md-6 col-xs-6 text-center">
                <form action="{{ route('pub.matches.request-match', $user) }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-warning btn-block">Request Match</button>
                    <div class="text-center util__mb--large">
                        <a href="{{ route('pub.faq.index') }}#match" class="small text-info" target="_blank">
                        What is a Match?</a>
                    </div>
                </form>
            </div>
        @endif
    @endcan
@endauth

