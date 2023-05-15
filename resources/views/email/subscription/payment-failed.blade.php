@component('mail::message')
<p>Hey {{ ucfirst($user->first_name) }},</p>

<p>Your auto payment retry being failed. Please login to your account to make manual payment.</p>

@component('mail::button', ['url' => route('login') ])
Login Now
@endcomponent

<p>Call or text for information at <a href="tel:7045695072">704-569-5072</a></p>

Thank You,<br>
Team {{ config('app.name') }}
@endcomponent