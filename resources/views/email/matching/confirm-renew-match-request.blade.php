@php 
	$authUser = auth()->user();
@endphp

@component('mail::message')
# Congratulations {{ ucfirst($user->first_name) }}, you have successfully renewed your match with {{ ucfirst($authUser->first_name) }}

You and {{ ucfirst($authUser->first_name) }} are now matched on Render. View and edit your
matches in your profile.

@component('mail::button', ['url' => route('pub.profile.matches.index') ])
    Manage Matches
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
