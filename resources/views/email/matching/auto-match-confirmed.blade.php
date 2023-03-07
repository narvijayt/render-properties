@component('mail::message')
<p>Hey {{ ucfirst($brokerUser->first_name) }},<br/> Congratulations, a Real Estate Agent in your area, {{ $realtorUser->first_name.' '.$realtorUser->last_name }} has connected with you. Click on the link below to see details. </p>


@component('mail::button', ['url' =>  route('realtordetails.automatch', ['brokerId' => $brokerUser->user_id, 'realtorId' => $realtorUser->user_id]) ])
View Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent