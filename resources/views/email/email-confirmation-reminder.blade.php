@component('mail::message', [
    'user' => $user,
    'email_type' => config('mail.email_types.email_confirmation_reminder')
])
@php
    $user_type = $user->user_type === 'realtor' ? 'lender' : 'realtor';
@endphp
# {{ $user->first_name }}, please verify your email. You've missed a lot since you were last here!

Please click below to verify your email address.

@component('mail::button', ['url' => route('auth.email-verification', [
    'token' => $user->email_token,
    'utm_source' => 'email',
    'utm_medium' => 'email',
    'utm_campaign' => 'email_confirmation_reminder',
])])
Verify Email
@endcomponent

If the button doesn't work you can visit this url to confirm your address: {{ route('auth.email-verification', [
    'token' => $user->email_token,
    'utm_source' => 'email',
    'utm_medium' => 'email',
    'utm_campaign' => 'email_confirmation_reminder',
]) }}

@if($areaUsers > 0)
## What's New

There are **{{ $areaUsers }}** {{ str_plural($user_type, $areaUsers) }} in your area waiting for you
to contact them!

<a href="{{ route('pub.connect.index', [
    'user_types' => [$user_type],
    'search_type' => 'radius',
    'radius' => 100,
    'location' => "{$user->city}, {$user->state} {$user->zip}",
    'utm_source' => 'email',
    'utm_medium' => 'email',
    'utm_campaign' => 'email_confirmation_reminder',
    ]) }}">Find them now!</a>
@endif



Thank you,<br>
{{ config('app.name') }}
@endcomponent
