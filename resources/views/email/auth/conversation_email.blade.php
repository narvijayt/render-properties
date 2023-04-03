@component('mail::message')
# {{ $user['receiver_first_name']}}, You have receive new message from {{ $user['sender_first_name'] }}!


Subject: {{$user['conv_title']}}<br>
Message: {{$user['conv_message']}}<br>





Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent