@extends('pub.message-center.layouts.message-center')

@section('title')
    Message Center
@endsection

@section('page-content')
    <message-center :conversations="{{ $conversationSeed->toJson() }}"></message-center>
@endsection