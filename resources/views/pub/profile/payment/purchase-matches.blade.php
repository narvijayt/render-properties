@extends('pub.profile.layouts.profile')

@section('title')
    Purchase Matches
@endsection

@section('page_content')

    <div class="panel panel-default">
        <div class="panel-heading">Purchase Additional Matches</div>
        <div class="panel-body">
            <p class="util__mb--small small">Purchase will be charged to the {{ $user->card_brand }} on file ending in {{ $user->card_last_four }}</p>
            <purchase-additional-matches action="{{ route('pub.profile.payment.purchase-matches-store') }}" cost="59.99" token="{{ csrf_token() }}"></purchase-additional-matches>
        </div>
    </div>

@endsection

