@component('mail::message')
<p>Hey {{ ucfirst($realtorUser->first_name) }},<br/>Time to increase your sales! Congratulations, a Loan Officer in your area, <strong>{{ $brokerUser->first_name.' '.$brokerUser->last_name }}</strong> wants to connect with you. Click on the link below to see the details. </p>


@component('mail::button', ['url' =>  route('view.automatch', ['brokerId' => $brokerUser->user_id, 'realtorId' => $realtorUser->user_id]) ])
View Details
@endcomponent

Thank You,<br>
Team {{ config('app.name') }}
@endcomponent