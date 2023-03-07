@component('mail::message')
# Test Email


Test email received from [{{ config('app.url') }}]({{ config('app.url') }})

Thanks,<br>
{{ config('app.name') }}
@endcomponent