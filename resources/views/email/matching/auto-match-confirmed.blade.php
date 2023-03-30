@component('mail::message')
<p>Hey {{ ucfirst($brokerUser->first_name) }},<br/> Congratulations, a Real Estate Agent in your area, <strong>{{ $realtorUser->first_name.' '.$realtorUser->last_name }}</strong> has connected with you. Click on the link below to see details. </p>


@component('mail::button', ['url' =>  route('realtordetails.automatch', ['brokerId' => $brokerUser->user_id, 'realtorId' => $realtorUser->user_id]) ])
View Details
@endcomponent

<p>Call or text for information at <a href="tel:7045695072">704-569-5072</a></p>

Thank You,<br>  
Team {{ config('app.name') }}
@endcomponent