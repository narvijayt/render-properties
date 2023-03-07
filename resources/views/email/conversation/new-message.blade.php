@component('mail::message', [
    'user' => $toUsers->first(),
    'email_type' => config('mail.email_types.conversation_messages')
])
# {{ $toUsers->first()->first_name }} sent you a message


@component('mail::panel')
From: {{ $msg->user->first_name }}

{{ $msg->message_text }}
@endcomponent

@component('mail::button', ['url' => route('pub.message-center.index')])
    Reply Now In Your Message Center
@endcomponent

@endcomponent