@component('mail::message')
<p>Hey {{ ucfirst($user->first_name) }},</p>

<p>Your auto payment retry being failed. Please login to your account to make manual payment.</p>

@component('mail::button', ['url' => route('login') ])
Login Now
@endcomponent


Thank You,<br>
Team {{ config('app.name') }}
@endcomponent