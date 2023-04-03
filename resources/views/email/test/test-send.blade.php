@component('mail::message')
# Test Email


Test email received from [{{ config('app.url') }}]({{ config('app.url') }})

Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent