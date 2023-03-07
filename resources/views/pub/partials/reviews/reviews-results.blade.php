<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="container" style="padding:0px;">
                <div class=row>
                    <div class="col-md-3" style="white-space: nowrap; padding-left: 0px;">
                        <img src="{{ $review->reviewer->avatarUrl() }}" class="img-responsive"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <h3 style="float: inherit; vertical-align: top; margin:0px;">@if(Auth::check() && $review->reviewer_user_id == Auth::user()->user_id) Your  @else{{$review->reviewerFullName()}}'s @endif review</h3>
            </div>
            <div class="row">
                    @component('pub.components.ratings', ['rating' => $review->rating, 'class' => 'small'])
                    @endcomponent
            </div>
            <div class="row">
                <span style="font-size: 16px;">
                    {{$review->message}}
                </span>
            </div>
            @if(Auth::check())
                @if($review->status == \App\Enums\ReviewStatusType::UNSEEN && $review->subject->user_id == Auth::user()->user_id)
                    <div class="row">
                        <a class="btn btn-warning" style="margin-right:10px;" href="{{route('pub.reviews.accept', $review)}}"><i class="fa fa-check" style="margin-right: 1px;"></i>Accept</a>
                        <a class="btn btn-warning" href="{{route('pub.reviews.reject', $review)}}"><i class="fa fa-ban" style="margin-right: 1px;"></i>Reject</a>
                    </div>
                @endif
                @can('isreviewer', $review)
                    <div class="row">
                        <a class="btn btn-warning" style="margin-right:10px;" href="{{route('pub.reviews.edit', $review)}}"><i class="fa fa-pencil-square-o" style="margin-right: 1px;"></i>Edit</a>
                    </div>
                @endcan
            @endif
        </div>
    </div>
    <hr>
</div>