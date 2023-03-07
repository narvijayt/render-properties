@component('mail::message')
# New message receive from {{ $message->name }}

Name: {{ $message->name }}<br />
Email: {{ $message->email }}<br />
Phone: {{ $message->phone }}<br />
Subject: {{ $message->subject }}<br />
Message: {{ $message->message }}

@endcomponent
