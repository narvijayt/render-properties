@component('mail::message')
<p>Hey {{ ucfirst($realtorUser->first_name) }},</p>

<p>Do you work with first time home buyers? <strong>{{ $brokerUser->first_name.' '.$brokerUser->last_name }}</strong> is seeking a realtor partner match for Render’s home buyer lead program. </p>

<p>The leads have zero upfront fees for Realtors. Click on the link below to see details</p>


@component('mail::button', ['url' =>  route('view.automatch', ['brokerId' => $brokerUser->user_id, 'realtorId' => $realtorUser->user_id]) ])
View Details
@endcomponent

Thank You,<br>
Team {{ config('app.name') }}
@endcomponent