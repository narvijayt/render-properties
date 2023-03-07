@php 
	$authUser = auth()->user();
@endphp

@component('mail::message')
# Hello {{ ucfirst($user->first_name) }}, you have received a match renewal request from {{ ucfirst($authUser->first_name) }}

You can view the request in your profile

@component('mail::button', ['url' => route('pub.profile.matches.index')])
    View Match Requests
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

