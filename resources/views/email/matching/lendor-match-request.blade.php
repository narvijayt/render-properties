@php 
	$authUser = auth()->user();
@endphp

@component('mail::message')
{{--
# Hello {{ ucfirst($user->first_name) }}, you have received a new match request from {{ ucfirst($authUser->first_name) }}

You can view the request in your profile
--}}


<p>Hi {{ ucfirst($user->first_name) }}</p>
<p>I see that you are a Realtor registered on <a href="{{ url('') }}">{{ url('') }}</a> and would like to be part of the home buyer lead program. As a loan officer member of the program and I wanted to introduce myself. Are you still interested in taking advantage of the discounted referral fee home buyer leads program? If so, I'd be happy to assist. Please accept my match request and I will reach out to see if we are a good fit to work together.</p>

@component('mail::button', ['url' => route('pub.profile.matches.index')])
View Match Requests
@endcomponent

<p>Call or text for information at <a href="tel:704-569-5072">704-569-5072</a></p>

Thank You,<br>
{{ ucfirst($authUser->first_name) }}
{{--
    {{ config('app.name') }}
--}}
@endcomponent
