@extends('layouts.app')
@section('title')
    Subscribe Now
@endsection

@section('meta')
    @php
        $description = 'Subscribe Now to Render';
        $title = 'Subscription Required';
    @endphp
    {{ meta('description', $description) }}

    {{ openGraph('og:title', $title) }}
    {{ openGraph('og:type', 'profile') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}

    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', $title) }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}

    {{ googlePlus('name', $title) }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

<?php /** @var \App\User $user */ ?>
@section('content')
    @component('pub.components.banner', ['banner_class' => 'profile'])
        Subscribe Now
    @endcomponent

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="color: #0a4a80">
                <h3>Premium Subscription Required</h3>
                <h4>Indulge—in so much value, for so little! Please take advantage of our “Pre Spring Sale” and save on a subscription to RBC today.</h4>

                <p>Search and view Realtors seeking loan officers in your local area or all over the country.</p>

                <p>Connect and send messages to the Realtors on the site directly from the site.</p>

                <p>Have full access to all the Realtors on the site and their contact information to make it easy to communicate with them off the site.</p>

                <p>Have access to the Realtors sales tracking for the past 12 months.</p>

                <p>When a connection is made and both the loan officer and Realtor confirm a match the Realtor will no longer be available to other loan officers.</p>

                <p>Appear in Realtor searches for a mortgage lender.</p>

                <p>Review Realtors.</p>

                <p>All of this for $59.00 a month no contracts required.<br />
                    Call 800-217-5602 for prices on exclusivity or bulk pricing.</p>

                <a href="{{ route('pub.profile.payment.index') }}" class="btn btn-warning btn-lg">Subscribe Now</a>
            </div>
        </div>
    </div>
@endsection
