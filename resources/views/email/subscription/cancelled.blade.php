@component('mail::message')
<p>Hey {{ ucfirst($user->first_name) }},</p>

<p>Your auto payment retries are failed and Subscription has been cancelled. Please login to your account and make manual payment to continue to access your Render Account. </p>

@component('mail::button', ['url' => route('login') ])
Login Now
@endcomponent

<p>Call or text for information at <a href="tel:7045695072">704-569-5072</a></p>


Thank You,<br>
Team {{ config('app.name') }}
@endcomponent