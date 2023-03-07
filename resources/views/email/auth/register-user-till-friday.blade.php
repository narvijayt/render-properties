@component('mail::message')
# {{ $title }}

The report for new registered user with in this week is attached.
Number of users registered: {{$total_users}}
@endcomponent