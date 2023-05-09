@component('mail::message')
<p>Hey {{ ucfirst($user->first_name) }},</p>

<p>Your auto payment reties failed and Subscription has been cancelled. Please login to your account and make manual payment to continue to access your Render Account. </p>

@component('mail::button', ['url' => route('login') ])
Login Now
@endcomponent


Thank You,<br>
Team {{ config('app.name') }}
@endcomponent