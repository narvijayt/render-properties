@extends('pub.profile.layouts.profile')
@section('title','Social Reviews | Edit Profile')
@section('meta')
    {{ meta('description', config('seo.description')) }}
    {{ meta('keywords', config('seo.keyword')) }}
@endsection
@section('page_content')
    <div class="row">
        <div class="col-md-8">

            <form action="{{ route('pub.profile.profileSocialReviews.update') }}" method="post">
                <h4 class="margin-top-none">Add Social Reviews To Your RBC Profile</h4>
                {{ csrf_field() }}
                
                {{ method_field('PATCH') }}

                <div class="form-group{{ $errors->has('zillow_screenname') ? ' has-error' : '' }}">
                    <label for="zillow_screenname" class="control-label">Zillow</label>
                    <p><code>Add your Zillow Screen Name to the field below and Zillow reviews will be published on your RBC profile page.</code></p>

                    <input placeholder="Type/Paste Your Zillow Screen Name Here" id="zillow_screenname" type="text" class="form-control" name="zillow_screenname" value="{{isset($socialReviews->zillow_screenname) ? $socialReviews->zillow_screenname : ''}}"/>

                    @if ($errors->has('zillow_screenname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('zillow_screenname') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('facebook_embedded_review') ? ' has-error' : '' }}">
                    <label for="facebook_embedded_review" class="control-label">Facebook</label>
                    <p><code>You can copy embed code of reviews from your Facebook Business page by clicking on the 3 dots on the top right of the review. Between each embed code add &lt;br&gt;</code></p>

                    <textarea placeholder="Paste Facebook Reviews Embed Code Here. Make sure to add <br> between each embed code." style="min-height:400px;" id="facebook_embedded_review" type="text" class="form-control tinyMCE" name="facebook_embedded_review">{{isset($socialReviews->facebook_embedded_review) ? $socialReviews->facebook_embedded_review : ''}}</textarea>
                    
                    @if ($errors->has('facebook_embedded_review'))
                        <span class="help-block">
                            <strong>{{ $errors->first('facebook_embedded_review') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="form-group{{ $errors->has('yelp_embedded_review') ? ' has-error' : '' }}">
                    <label for="yelp_embedded_review" class="control-label">Yelp</label>
                    <p><code>You can copy embed code of reviews from your Yelp Profile page by clicking on the 3 dots on the top right of the review. Between each embed code add &lt;br&gt;</code></p>

                    <textarea placeholder="Paste Yelp Reviews Embed Code Here. Make sure to add <br> between each embed code." style="min-height:400px;" id="yelp_embedded_review" type="text" class="form-control tinyMCE" name="yelp_embedded_review">{{isset($socialReviews->yelp_embedded_review) ? $socialReviews->yelp_embedded_review : ''}}</textarea>
                    <p><code>Between each embed code add &lt;br&gt;</code></p>
                    @if ($errors->has('yelp_embedded_review'))
                        <span class="help-block">
                            <strong>{{ $errors->first('yelp_embedded_review') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update</button>

            </form>

        </div>

    </div>

{{--
@section('scripts')
    @parent
    <script src="{{asset('js')}}/admin/tinymce/tinymce.min.js"></script>
    $(document).ready(function(){
        tinymce.init({
            selector: '.tinyMCE'
        });
    });
@show

--}}


@endsection