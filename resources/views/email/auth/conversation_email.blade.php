@component('mail::message')
# {{ $user['receiver_first_name']}}, You have receive new message!


Subject: {{$user['conv_title']}}<br>
Message: {{$user['conv_message']}}<br>





Thanks,<br>
{{ config('app.name') }}
@endcomponent