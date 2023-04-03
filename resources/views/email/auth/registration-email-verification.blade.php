@component('mail::message')
# {{ $user->first_name }}, thank you for registering!

Please click below to verify your email address.
@component('mail::button', ['url' => config('app.url').'/register/verify/'.$user->email_token])
Verify Email
@endcomponent

### As a member of {!! get_application_name() !!} you can enjoy the following benefits
* 30 days real estate coaching from nationally renowned Bill "The Coach" Sparkman
* Connect with active & productive lenders & real estate agents
* Build your referral network
* And many more!

If the button doesn't work you can visit this url to confirm your address
[{{ config('app.url').'/register/verify/'.$user->email_token }}]({{ config('app.url').'/register/verify/'.$user->email_token }})

Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent