@php 
$match = (!isset($match)) ? false : $match;
$viewDetails = false;
$sub_title = $title = '';
if($user->user_type === 'broker'){
    $sub_title = $title = 'lender';
}else if($user->user_type === 'vendor'){
    $sub_title = $title = 'vendor';
}else{
    $title = 'real estate agent';
    $sub_title = "agent";
}
@endphp


@if(Auth::user())
    @php 
        $authUser = auth()->user();
        if($match == false && $authUser->isMatchedWith($user)){
            $match = true;
        }

        if( $match || $authUser->user_type == 'broker'){
            $viewDetails = true;
        }elseif( $authUser->user_type == 'vendor' && $authUser->payment_status == 1){
            $viewDetails = true;
        }
    @endphp
@endif

<div class="row">
    <div class="col-md-6">
        <div class="user-basic-info-section">
            <h3 class="text-primary">{{ $user->first_name }} {{ ($match || Auth::user()) ? $user->last_name : '' }} {!! user_verified_badge($user->user_id, true) !!}</h3>
            
            <h3 class="text-warning text-uppercase mt-0">{{ title_case($title) }}</h3>

            <!-- <div class="text-uppercase d-flex">
                <div class="col">Render Rating: </div>
                <div class="col"><h5 class="m-0">4.75 (Out of 5)</h5></div>
            </div> -->
        </div>

        <div class="card bg-light mp-2 p-2 mt-2 mb-3"> 
            @if($match)
                @if($match->isAccepted())
                    <h4 class="text-primary text-center match-info-heading mt-0">Congratulations! You and {{ ucfirst($user->first_name) }} are now connected.</h4>
                    <p class="text-center text-dark font-weight-bold mb-1">Now you can send text to this {{ ucfirst($sub_title) }} by clicking "Send a Text" button below:</p>
                @else
                    @if(Auth::user() && Auth::user()->user_id == $match->user_id1)
                        <h4 class="text-primary text-center match-info-heading mt-0">Congratulations! Your requested has been sent to {{ ucfirst($user->first_name) }} to connect.</h4>
                        <!-- <p>To connect with this {{ ucfirst($sub_title) }}, click below:</p> -->
                    @else
                        <h4 class="text-primary text-center match-info-heading mt-0">Congratulations! You are requested by {{ ucfirst($user->first_name) }} to connect.</h4>
                        <p class="text-center text-dark font-weight-bold mb-1">To connect with this {{ ucfirst($sub_title) }}, click below:</p>
                    @endif
                @endif
            @else
                <h4 class="text-primary text-center match-info-heading mt-0">
                    @if(!Auth::user())Join Render's lead program.@endif Match with this {{ ucfirst($sub_title) }} today!
                </h4>
            @endif
            
            @if(!$match && Auth::user())
                @if(!$authUser->isMatchedWith($user) && $user->user_type != auth()->user()->user_type )
                    <p class="text-center text-dark font-weight-bold mb-1">To connect with this {{ ucfirst($sub_title) }}, click to match:</p>
                    <form action="{{ route('pub.matches.request-match', $user) }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="text-uppercase btn btn-warning btn-lg shadow mb-3 btn-block">Match Now</button>
                    </form> 
                @endif
            @elseif(!$match && !Auth::user())
                <p class="text-center text-dark font-weight-bold mb-1">Please login to connect with this {{ ucfirst($sub_title) }}.</p>
            @elseif(($match && $match->isAccepted() == false) && (Auth::user()->user_id != $match->user_id1) )
                <form method="post" action="{{ route('create.automatch', ['authUserId' => $authUser->user_id, 'userId' => $user->user_id]) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="match_id" value="{{ $match->match_id }}" />
                    <button type="submit" name="create-auto-match" id="create-auto-match" class="text-uppercase btn btn-warning btn-lg shadow mb-3 btn-block">Confirm Match</button>
                </form>
            @endif

            <div class="text-center user-contact-details">
                @if(!empty($user->phone_number))
                    <div class="full-row">
                        <i class="fa fa-phone"></i>
                        @if($match || $viewDetails)
                            <a class="text-dark" href="tel:{{ $user->phone_number }}">{{ $user->phone_number }}</a>
                        @else
                            {!! get_locked_html_string($user->phone_number) !!}
                        @endif
                    </div>
                @endif

                @if(!empty($user->email))
                    <div class="full-row">
                        <i class="fa fa-envelope"></i>
                        @if($match || $viewDetails)
                            <a class="text-dark" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        @else
                            {!! get_locked_html_string($user->email) !!}
                        @endif
                    </div>
                @endif
            </div>
                
            <div class="action-buttons-section mt-1">
                <div class="form-group mb-2 text-sms-section">
                    @if($match || $viewDetails)
                        <a class="btn btn-warning text-dark text-uppercase send-sms-link" href="sms:{{ $user->phone_number }}">Send a Text </a>
                    @else
                        <a class="btn btn-warning text-dark text-uppercase disbaled-contact-link" href="javascript:;">Send a Text</a>
                    @endif
                </div>

                <div class="icons-box">
                    <div class="form-group mb-2 user-contact-info">
                        @if( ($match && $match->isAccepted() ) && Auth::user())
                            @if($user->user_id != Auth::user()->user_id)    
                                <i class="fa fa-wechat"></i> <send-message :recipient="{{ $user }}"></send-message>
                            @endif
                        @elseif($viewDetails)
                            <i class="fa fa-wechat"></i> <send-message :recipient="{{ $user }}"></send-message>
                        @else
                            <a class="text-dark text-uppercase disbaled-contact-link" href="javascript:;"><i class="fa fa-wechat"></i></a>
                            <a class="text-dark text-uppercase disbaled-contact-link" href="javascript:;">Chat</a>
                        @endif
                    </div>
                    <div class="form-group mb-2 user-contact-info">
                        @if($match || $viewDetails)
                            <a class="text-dark text-uppercase" href="tel:{{ $user->phone_number }}"><i class="fa fa-phone"></i></a> 
                            <a class="text-dark text-uppercase" href="tel:{{ $user->phone_number }}">Call</a>
                        @else
                            <a class="text-dark text-uppercase disbaled-contact-link" href="javascript:;"><i class="fa fa-phone"></i></a>
                            <a class="text-dark text-uppercase disbaled-contact-link" href="javascript:;">Call</a>
                        @endif
                    </div>
                    <div class="form-group mb-2 user-contact-info">
                        @if($match || $viewDetails)
                            <a class="text-dark text-uppercase" href="mailto:{{ $user->email }}"><i class="fa fa-envelope"></i></a>
                            <a class="text-dark text-uppercase" href="mailto:{{ $user->email }}">Email</a>
                        @else
                            <a class="text-dark text-uppercase disbaled-contact-link" href="javascript:;"><i class="fa fa-envelope"></i></a>
                            <a class="text-dark text-uppercase disbaled-contact-link" href="javascript:;">Email</a>
                        @endif
                    </div>

                    
                </div>
            </div>
        </div>

        @if($user->firm_name)
            <div class="form-group">
                <strong class="text-uppercase">Company:</strong>
                <div class="">{!! ($match || $viewDetails) ? $user->firm_name : get_locked_html_string($user->firm_name) !!}</div>
            </div>
        @endif

        <div class="form-group">
            <strong class="text-uppercase">Location:</strong>
            <div class="">{!! ($match || $viewDetails) ? $user->city.','.$user->state : get_locked_html_string($user->city.', '.$user->state) !!}</div>
        </div>

        @if($user->website)
            <div class="form-group">
                <strong class="text-uppercase">Website:</strong>
                @if($match || $viewDetails)
                    <div class=""><a href="{{ strpos($user->website,'http') ? $user->website : 'https://'.$user->website  }}" target="_blank">{{ $user->website }}</a></div>
                @else
                    <div class="">{!! get_locked_html_string($user->website) !!}</div>
                @endif
            </div>
        @endif

        @if($user->license)
            <div class="form-group">
                <strong class="text-uppercase">Real Estate License:</strong>
                <div class="">{!! ($match || $viewDetails) ? $user->license : get_locked_html_string($user->license) !!}</div>
            </div>
        @endif

        @if($user->zip)
            <div class="form-group">
                <strong class="text-uppercase">Areas/Locations Served:</strong>
                <div class="">{!! ($match || $viewDetails) ? $user->zip : get_locked_html_string($user->zip) !!}</div>
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