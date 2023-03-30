@php 
$match = (!isset($match)) ? false : $match;
@endphp


@if(Auth::user())
    @php 
        $authUser = auth()->user();
        if($authUser->isMatchedWith($user)){
            $match = true;
        }
    @endphp
@endif

<div class="row">
    <div class="col-md-6">
        <div class="user-basic-info-section">
            <h3 class="text-primary">{{ $user->first_name }} {!! ($match) ? $user->last_name : get_locked_html_string($user->last_name) !!}</h3>
            
            <h3 class="text-warning text-uppercase mt-0">{{ title_case($user->user_type === 'broker' ? 'lender' : 'real estate agent') }}</h3>

            <!-- <div class="text-uppercase d-flex">
                <div class="col">Render Rating: </div>
                <div class="col"><h5 class="m-0">4.75 (Out of 5)</h5></div>
            </div> -->
        </div>

        <div class="card bg-light mp-2 p-2 mt-2 mb-3">
            @if($match)
                <h4 class="text-primary mt-0">Congratulations! You and {{ ucfirst($user->first_name) }} are now connected.</h4>
                <p>To connect with this {{ $user->user_type == 'broker' ? 'Lender' : 'Agent'}}, click below:</p>
            @else
                <h4 class="text-primary mt-0">Join Render's lead program. Match with this {{ $user->user_type == 'broker' ? 'Lender' : 'Agent'}} today!</h4>
                <p>To connect with this {{ $user->user_type == 'broker' ? 'Lender' : 'Agent'}}, click to match:</p>
            @endif
            
            @if(!$match && Auth::user())
                @if($user->user_type !="vendor" && auth()->user()->user_type != 'vendor' && !$authUser->isMatchedWith($user) && $user->user_type != auth()->user()->user_type )
                    <form action="{{ route('pub.matches.request-match', $user) }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="text-uppercase btn btn-warning btn-lg shadow mb-3 btn-block">Match Now</button>
                    </form>
                @endif
            @elseif($match && Auth::user())
                <div class="user-profile__send-message-container">
                    @if($user->user_id != Auth::user()->user_id)
                        <send-message :recipient="{{ $user }}"></send-message>
                    @endif
                </div>
            @elseif($match== false && $user->user_type == 'broker' && (isset($realtorUser) && in_array($realtorUser->zip, explode(",", $user->zip))))
                <form method="post" action="{{ route('create.automatch', ['brokerId' => $user->user_id, 'realtorId' => $realtorUser->user_id]) }}">
                    {{ csrf_field() }}
                    <button type="submit" name="create-auto-match" id="create-auto-match" class="text-uppercase btn btn-warning btn-lg shadow mb-3 btn-block">Match Now</button>
                </form>
            @endif

            <div class="form-group mb-2 user-contact-info">
                @if($match)
                    <i class="fa fa-phone"></i> <a class="text-dark" href="tel:{{ $user->phone_number }}">{{ $user->phone_number }}</a>
                @else
                    <i class="fa fa-phone"></i> {!! get_locked_html_string($user->phone_number) !!}
                @endif
            </div>
            <div class="form-group mb-2 user-contact-info hide-desktop">
                @if($match)
                    <i class="fa fa-wechat"></i> <a class="text-dark" href="sms:{{ $user->phone_number }}">Send SMS</a>
                @else
                    <i class="fa fa-wechat"></i> {!! get_locked_html_string('Send SMS') !!}
                @endif
            </div>
            <div class="form-group mb-2 user-contact-info">
                @if($match)
                    <i class="fa fa-envelope"></i> <a class="text-dark" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                @else
                    <i class="fa fa-envelope"></i> {!! get_locked_html_string($user->email) !!}
                @endif
            </div>
        </div>

        @if($user->firm_name)
            <div class="form-group">
                <strong class="text-uppercase">Company:</strong>
                <div class="">{!! ($match) ? $user->firm_name : get_locked_html_string($user->firm_name) !!}</div>
            </div>
        @endif

        <div class="form-group">
            <strong class="text-uppercase">Location:</strong>
            <div class="">{!! ($match) ? $user->city : get_locked_html_string($user->city) !!}{!! ($match) ? ', '.$user->state : get_locked_html_string(', '.$user->state) !!}</div>
        </div>

        @if($user->website)
            <div class="form-group">
                <strong class="text-uppercase">Website:</strong>
                @if($match)
                    <div class=""><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></div>
                @else
                    <div class="">{!! get_locked_html_string($user->website) !!}</div>
                @endif
            </div>
        @endif

        @if($user->license)
            <div class="form-group">
                <strong class="text-uppercase">Real Estate License:</strong>
                <div class="">{!! ($match) ? $user->license : get_locked_html_string($user->license) !!}</div>
            </div>
        @endif

        @if($user->zip)
            <div class="form-group">
                <strong class="text-uppercase">Areas/Locations Served:</strong>
                <div class="">{!! ($match) ? $user->zip : get_locked_html_string($user->zip) !!}</div>
            </div>
        @endif
    </div>
    
    <div class="col-md-6">
        @if($user->bio)
            <div class="form-group">
                <strong class="text-uppercase">About:</strong>
                <div class="">{{ $user->bio }}</div>
            </div>
        @endif

        @if($user->specialties)
            <div class="form-group">
                <strong class="text-uppercase">Specialization</strong>
                <div class="">{{ $user->specialties }}</div>
            </div>
        @endif
    </div>

</div>