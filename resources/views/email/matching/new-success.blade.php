@component('mail::message', [
    'user' => $to,
    'email_type' => config('mail.email_types.match_requests')
])
# Congratulations {{ $to->first_name }}, you have successfully matched with {{ $from->first_name }}

You and {{ $from->first_name }} are now matched on Render. View and edit your
matches in your profile.

@component('mail::button', ['url' => route('pub.profile.matches.index') ])
Manage Matches
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
