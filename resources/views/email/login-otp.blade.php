@component('mail::message')
<p>Hey {{ ucfirst($user->first_name) }},</p>

<p>Please enter the below mentioned OTP to login into your account. </p>

<p>OTP Code: <strong style="font-size:18px; line-height:18px;">{{ $otp_code }}</strong></p>

<p>This OTP will be valid for 10 minutes only.</p>

Thank You,<br>
Team {{ config('app.name') }}
@endcomponent