@extends('layouts.app')

@section('title')
    Edit Review
@endsection

@section('content')
<div class="container">
<form action="{{ route('pub.reviews.edit', $review) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <input class="hidden" id="user_id" name="user_id" value="{{$review->user_id}}"/>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editing your Review on {{ $review->subject->first_name }}</h4>
    </div>
    <div class="modal-body">
        <div class="form-group {{ $errors->has('reviewRating') ? 'has-error' : '' }}">
            <label class="control-label" for="reviewRating">
                @if($errors->has('reviewRating'))<i class="fa fa-times-circle-o"></i>@endif Rating
            </label>

            <select class="form-control" id="reviewRating" name="reviewRating">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <div class="form-group {{ $errors->has('reviewMessage') ? 'has-error' : '' }}">
            <label class="control-label" for="reviewMessage">
                @if($errors->has('reviewMessage'))<i class="fa fa-times-circle-o"></i>@endif Review Message
            </label>
            <textarea
                    type="text"
                    class="form-control"
                    placeholder="Please Write your review of {{$review->subject->first_name.' '.$review->subject->last_name}} here"
                    name="reviewMessage"
                    rows="3"
                    >@if((old('reviewMessage') != null)){{old('reviewMessage')}}@endif @if(old('reviewMessage') == null){{$review->message}}@endif</textarea>
            @if($errors->has('reviewMessage'))
                <span class="help-block">{{ $errors->first('reviewMessage') }}</span>
            @endif
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</form>
</div>
@endsection