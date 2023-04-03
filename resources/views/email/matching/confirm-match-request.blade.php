@php 
	$authUser = auth()->user();
@endphp

@component('mail::message')
# Congratulations {{ ucfirst($user->first_name) }}, you have successfully matched with {{ ucfirst($authUser->first_name) }}

You and {{ ucfirst($authUser->first_name) }} are now matched on {!! get_application_name() !!}. View and edit your
matches in your profile.

@component('mail::button', ['url' => route('pub.profile.matches.index') ])
Manage Matches
@endcomponent

Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent
