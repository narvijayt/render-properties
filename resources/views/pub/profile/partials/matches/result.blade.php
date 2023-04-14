<?php /** @var \App\Match $match */ ?>
@php
    $oppUser = $match->getOppositeParty($user);
@endphp
<li>
    <div class="match-result">
        <div class="row">

            <div class="col-xs-6 match-result__content">
                <div class="match-result__image">
                    <img src="{{ $oppUser->avatarUrl() }}" />
                </div>
                <div class="match-result__name">
                    {{ $oppUser->full_name() }} {!! user_verified_badge($oppUser->user_id, false, 'badge-sm') !!}
                  
                </div>
                <span>
                    <a href="{{ route('pub.user.show', $oppUser->user_id) }}">View Profile</a>
                </span>
            </div>


            <div class="col-xs-6 match-result__action-container">
                @if ($match->isAccepted())
                     @php
                        echo '<button class="btn btn-warning btn-sm" onclick="confirmMatch(\''.$match->match_id.'\' , \'remove\');">Remove Match</button>';
                    @endphp
                @endif
                @if (!$match->isAccepted() && !$match->isDeleted())
                     @php
                        echo '<button class="btn btn-warning btn-sm" onclick="confirmMatch(\''.$match->match_id.'\' , \'reject_match\');">Reject Match</button>';
                    @endphp
                @endif
               {{-- @if (!$match->isAcceptedBy($user) && $user->availableMatchCount() > 0) --}}
                @if (!$match->isAcceptedBy($user))
                    @php
                        echo '<button class="btn btn-warning btn-sm" onclick="confirmMatch(\''.$match->match_id.'\' , \'accept\');">Confirm</button>';
                    @endphp
                    
                @endif

                {{--@if (!$match->isAcceptedBy($user) && $user->availableMatchCount() <= 0 && $user->user_type === \App\Enums\UserAccountType::BROKER)--}}
                    {{--<a href="{{ route('pub.profile.payment.purchase-matches-show') }}"--}}
                       {{--class="btn btn-warning btn-sm"--}}
                       {{-->Purchase Additional Matches</a>--}}
                {{--@endif--}}

                {{--@can('requestMatch', $oppUser)--}}
                    {{--<form--}}
                        {{--class="match-result__form-action"--}}
                        {{--action="{{ route('pub.matches.request-match', $oppUser) }}"--}}
                        {{--id="request-match-{{ $oppUser->user_id }}"--}}
                        {{--method="POST">--}}
                        {{--{{ csrf_field() }}--}}
                        {{--<button--}}
                            {{--class="btn btn-warning btn-sm"--}}
                            {{--type="button"--}}
                            {{--data-toggle="modal"--}}
                            {{--data-confirm-submit="#request-match-{{ $oppUser->user_id }}"--}}
                            {{--data-confirm-message="Are you sure you wish to request a match with {{ $oppUser->full_name() }}"--}}
                            {{--data-target="#confirm-submit-modal"--}}
                        {{-->Request Match</button>--}}
                    {{--</form>--}}
                {{--@endcan--}}

                @can('renewMatch', $oppUser)
                    @php
                        echo '<button class="btn btn-warning btn-sm" onclick="confirmMatch(\''.$oppUser->user_id.'\' , \'renew\');">Renew Match</button>';
                    @endphp
                    <div>Renewable until {{ $match->deleted_at->addMonth(1)->format("F m, Y") }}</div>
                @endcan
                @can('acceptRenewMatch', $oppUser)
                   @php
                        echo '<button class="btn btn-warning btn-sm" onclick="confirmMatch(\''.$match->match_id.'\' , \'confirm_renew\');">Accept Match Renewal</button>';
                    @endphp
                @endcan

                @if($match->renewal && $match->renewal->isAcceptedBy($user) && !$match->renewal->isAcceptedBy($oppUser))
                    Pending Approval
                @endif

                @if($match->renewal)
                    @can('rejectRenewMatch', $oppUser)
                        @php
                            echo '<button class="btn btn-warning btn-sm" onclick="confirmMatch(\''.$match->match_id.'\' , \'reject_renew_match\');">Reject</button>';
                        @endphp
                    @endcan
                @endif
            </div>

        </div>
    </div>

</li>


