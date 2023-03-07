@component('mail::message', [
    'user' => $recipient,
    'email_type' => config('mail.email_types.match_requests')
])
# Hello {{ $recipient->first_name }}, you have received a match renewal request from {{ $fromUser->first_name }}

You can view the request in your profile

@component('mail::button', ['url' => route('pub.profile.matches.index')])
    View Match Requests
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

