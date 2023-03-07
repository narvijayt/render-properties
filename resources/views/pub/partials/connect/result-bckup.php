<article class="search-result">
    <div class="search-result__avatar-container">
        <img src="{{ $user->avatarUrl() }}" class="search-result__avatar" />
    </div>
    <div class="search-result__content">
        <div class="search-result__user-name">
            <strong>{{ $user->first_name }}</strong>
        </div>
        <div class="row">
            <div class="col-sm-6">

                <span class="search-result__detail">
                    {{ title_case($user->user_type === 'broker' ? 'lender' : 'real estate agent') }} <br />
                    {{ $user->city }}, {{ $user->state }}
                    @if(isset($user->specialties))
                       <span class="search-result__detail">Specialties: {{$user->specialties}}</span>
                    @endif
                    @if(isset($user->license))
                        <span class="search-result__detail">License#: {{$user->license}}</span>
                    @endif
                </span>
            </div>

            {{--<div class="col-sm-6 search-result__meta">--}}
                {{--@component('pub.components.ratings', ['rating' => $user->reviewRating(), 'class' => 'small'])--}}
                    {{--<a href="{{route('pub.reviews.others', $user->user_id)}}">{{$user->reviews->count()}} Reviews</a>--}}
                {{--@endcomponent--}}
            {{--</div>--}}
        </div>

    </div>

    <div class="search-result__footer">
        <a href="{{ route('pub.user.show', $user->user_id) }}"  class="btn btn-warning search-result__profile-link">View Member Profile</a>
    </div>
</article>