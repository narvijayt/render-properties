@extends('layouts.app')

@section('title')
    Reject Review
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h2 style="text-align: center; color:#005597;">Review being rejected</h2>
            <hr>
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
                    <h3 style="float: inherit; vertical-align: top; margin:0px;">{{$review->reviewerFullName()}}'s review</h3>
                </div>
                <div class="row">
                    @component('pub.components.ratings', ['rating' => $review->rating, 'class' => 'small'])
                    @endcomponent
                    <br>
                </div>
                <div class="row">
                    <label>Review Message</label>
                    <span style="font-size: 16px;">
                        {{$review->message}}
                    </span>
                </div>
                <div class="row">
                    <label>Reject Message</label>
                    <span style="font-size: 16px;">
                        {{$review->reject_message}}
                    </span>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <form action="{{route("pub.reviews.overrideSubmit", $review)}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <textarea id="override_message" name="override_message" class="form-control" rows="5" type="text" placeholder="Please write here why you are overriding this rejection." style="width:100%;"></textarea>
                    </div>
                    <div class="row">
                        <button value="submit" type="submit" class="btn btn-warning"> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection
