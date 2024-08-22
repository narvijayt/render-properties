@component('mail::message', [
    'formDetails' => $formDetails
])
# Introduction

New Lead Received!

First Name: {{ $formDetails->firstName }}
Last Name: {{ $formDetails->lastName }}
Email: {{ $formDetails->email }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent