@component('mail::message', [
    'user' => $user,
    'email_type' => config('mail.email_types.weekly_update')
])
@php
$user_type = $user->user_type === 'realtor' ? 'lender' : 'realtor';
@endphp
# {{ $user->first_name }}, here is what you are missing on {!! get_application_name() !!}

@if ($matches > 0 || $unreadCount > 0)
#### People are trying to contact you!
@endif
@if ($matches > 0)
<a href="{{ route('pub.profile.matches.index', [
    'utm_source' => 'email',
    'utm_medium' => 'email',
    'utm_campaign' => 'weekly_update',
]) }}">{{ $matches }} Pending Match Requests</a>
@endif

@if($unreadCount > 0)
<a href="{{ route('pub.message-center.index', [
    'utm_source' => 'email',
    'utm_medium' => 'email',
    'utm_campaign' => 'weekly_update',
]) }}">{{ $unreadCount }} Unread Messages</a>
@endif

@if ($areaUsers > 0 && $newAreaUsers > 0)
There are **{{ $areaUsers }}** {{ str_plural($user_type, $areaUsers) }} in your area, and
**{{ $newAreaUsers }}** new {{ str_plural($user_type, $newAreaUsers) }} since your last visit looking for business
opportunities!
@elseif($areaUsers > 0)
There are **{{ $areaUsers }}** {{ str_plural($user_type, $areaUsers) }} in your area are looking for business
opportunities!
@endif

@if ($areaUsers > 0 || $newAreaUsers > 0)
<a href="{{ route('pub.connect.index', [
    'user_types' => [$user_type],
    'search_type' => 'radius',
    'radius' => 100,
    'location' => "{$user->city}, {$user->state} {$user->zip}",
    'utm_source' => 'email',
    'utm_medium' => 'email',
    'utm_campaign' => 'weekly_update',
]) }}">Find your next business opportunity today!</a>
@endif

@if (!$user->subscribed('main') && $user->user_type === 'broker')
@component('mail::panel')
## Why Subscribe?

When you become a premium subscriber you show up in the Realtors search for lenders in your area.
Beat out the other lenders and subscribe today.

@component('mail::button', ['url' => route('pub.profile.payment.index')])
Subscribe Now
@endcomponent

@endcomponent
@endif



{{--Thank you,<br>--}}
{{--{{ config('app.name') }}--}}
@endcomponent
