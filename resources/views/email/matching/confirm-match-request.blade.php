@component('mail::message')
# Congratulations {{ ucfirst($user->first_name) }}, you have successfully matched with {{ ucfirst($authUser->first_name) }}

You and {{ ucfirst($authUser->first_name) }} are now matched on {!! get_application_name() !!}. Click on the link below to view the details.

@component('mail::button', ['url' => route('matchdetails.automatch', ['authUser' => $user->user_id, 'user' => $authUser->user_id]) ])
View Match Details
@endcomponent

Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent
