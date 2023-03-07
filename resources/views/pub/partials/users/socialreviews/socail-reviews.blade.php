<h2 class="bio-title line-left">Social Reviews</h2>
<!-- Nav tabs -->
<ul class="nav nav-tabs social-review-tabs" role="tablist">
    @if(!empty($userSocialReviews->zillow_screenname))
        <li role="presentation" class="active"><a href="#zillowReviews" aria-controls="zillowReviews" role="tab" data-toggle="tab">
            <img src="{{asset('img').'/zillow-icon.png'}}" style="width:40px;height:40px;" /> Zillow
        </a></li>
    @endif
    @if(!empty($userSocialReviews->facebook_embedded_review))
        <li role="presentation" class="{{(empty($userSocialReviews->zillow_screenname)) ? 'active' : ''}}"><a href="#faceBookReviews" aria-controls="faceBookReviews" role="tab" data-toggle="tab">
            <img src="{{asset('img').'/facebook-icon.png'}}" style="width:40px;height:40px;" /> Facebook
        </a></li>
    @endif
    @if(!empty($userSocialReviews->yelp_embedded_review))
        <li role="presentation" class="{{(empty($userSocialReviews->zillow_screenname) && empty($userSocialReviews->facebook_embedded_review)) ? 'active' : ''}}"><a href="#yelpReviews" aria-controls="yelpReviews" role="tab" data-toggle="tab">
            <img src="{{asset('img').'/yelp-logo-271.jpg'}}" style="width:40px;height:40px;" /> Yelp
        </a></li>
    @endif
</ul>

<!-- Tab panes -->
<div class="tab-content">
    @if(!empty($userSocialReviews->zillow_screenname))
        <div role="tabpanel" class="tab-pane active" id="zillowReviews">
            @include('pub.partials.users.socialreviews.zillow')
        </div>
    @endif
    @if(!empty($userSocialReviews->facebook_embedded_review))
        <div role="tabpanel" class="tab-pane {{(empty($userSocialReviews->zillow_screenname)) ? 'active' : ''}}" id="faceBookReviews">
            <div class="container">
                <div class="social-review-row">
                    @php echo $userSocialReviews->facebook_embedded_review @endphp
                </div>
            </div>
        </div>
    @endif
    @if(!empty($userSocialReviews->yelp_embedded_review))
        <div role="tabpanel" class="tab-pane {{(empty($userSocialReviews->zillow_screenname) && empty($userSocialReviews->facebook_embedded_review)) ? 'active' : ''}}" id="yelpReviews">
            <div class="container">
                <div class="social-review-row">
                    @php echo $userSocialReviews->yelp_embedded_review @endphp
                </div>
            </div>
        </div>
    @endif
</div>