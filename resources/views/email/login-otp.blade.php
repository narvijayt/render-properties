@component('mail::message')
<p>Hey {{ ucfirst($user->first_name) }},<br/> Use below code to login into your account. </p>
<br/>
<p><strong>OTP Code:</strong> {{ $otp_code }}</p>

Thank You,<br>
Team {{ config('app.name') }}
@endcomponent