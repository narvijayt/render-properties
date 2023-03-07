@extends('layouts.app')

@section('title')
    Reject Match
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
                    <span style="font-size: 16px;">
                        {{$review->message}}
                    </span>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h4>Valid reasons to reject a review</h4>
                <ul>
                    <li>I do not know this person</li>
                    <li>Foul Language</li>
                    <li>Inaccurate information</li>
                </ul>
            </div>
            <div class="col-md-6">
                <form action="{{route("pub.reviews.reject", $review)}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <textarea id="reject_message" name="reject_message" class="form-control" rows="5" type="text" placeholder="Please write here why you are rejecting this review." style="width:100%;"></textarea>
                    </div>
                    <div class="row">
                        @can('isSubject', $review)
                        <button value="submit" type="submit" class="btn btn-warning"> Submit</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
