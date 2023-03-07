@component('mail::message')
<p>Hey {{ ucfirst($realtorUser->first_name) }},<br/>Time to increase your sales! Congratulations a Loan Officer in your area, {{ $brokerUser->first_name.' '.$brokerUser->last_name }} wants to connect with you. Click on the link below to see details. </p>


@component('mail::button', ['url' =>  route('view.automatch', ['brokerId' => $brokerUser->user_id, 'realtorId' => $realtorUser->user_id]) ])
View Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent