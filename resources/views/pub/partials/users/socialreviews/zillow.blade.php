@if(isset($userSocialReviews->socialReviews->proReviews->review))
    @foreach($userSocialReviews->socialReviews->proReviews->review as $review)
        @include('pub.partials.users.socialreviews.reviews-results', ['review' => $review])
    @endforeach
@else
    <div class="row mt-3">
        <div class="alert alert-warning">No Review found on Zillow for this User!</div>
    </div>
@endif
