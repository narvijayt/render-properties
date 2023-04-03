@component('mail::message')
# {{ $user->first_name }}, Welcome to {{ config('app.name') }}

Thank you for subscribing! You now have access to a growing community of realtors
and brokers looking to improve the way we do business.

@component('mail::button', ['url' => route('pub.connect.index')])
Connect Now
@endcomponent

Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent
