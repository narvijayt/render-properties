@component('mail::message', ['formDetails' => $formDetails])
Hi @if (!filter_var($user_name, FILTER_VALIDATE_EMAIL)) <strong> {{ $user_name }}</strong> @else {{ $user_name }} @endif,

@if ($email_type === "detailed_with_neither_realtor_nor_broker_found")
There is no LO and REA found in this area.
@elseif ($email_type === "detailed_with_no_realtor_found")
There is no REA found in this area.
@elseif ($email_type === "detailed_with_no_broker_found")
There is no LO found in this area.
@elseif (in_array($email_type, ["detailed", "detailed_with_lead_matched"]))
A new lead has been received in your area. Here are the details:
@endif

@if (in_array($email_type, ["detailed_with_neither_realtor_nor_broker_found", "detailed_with_no_realtor_found", "detailed_with_no_broker_found", "detailed", "detailed_with_lead_matched"]))
@php
    $timeToContact = $formDetails->formPropertyType === "sell" ? implode(", ", json_decode($formDetails->timeToContact, true)) : '';
    $sellUrgency = $formDetails->formPropertyType === "sell" ? implode(", ", json_decode($formDetails->sellUrgency, true)) : '';
@endphp

<table style="background-color: #eee; padding: 15px">
    <tr>
        <td><strong>First Name:</strong></td>
        <td>{{ $formDetails->firstName ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Last Name:</strong></td>
        <td>{{ $formDetails->lastName ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Email:</strong></td>
        <td>{{ $formDetails->email ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Phone Number:</strong></td>
        <td>{{ $formDetails->phoneNumber ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Street Address:</strong></td>
        <td>{{ $formDetails->streetAddress ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Street Address Line 2:</strong></td>
        <td>{{ $formDetails->streetAddressLine2 ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>City:</strong></td>
        <td>{{ $formDetails->city ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>State:</strong></td>
        <td>{{ $formDetails->state ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Postal Code:</strong></td>
        <td>{{ $formDetails->postal_code ?? '' }}</td>
    </tr>

    @if ($formDetails->formPropertyType === "sell")
    <tr>
        <td><strong>Best Time To Contact You:</strong></td>
        <td>{{ $timeToContact ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>How Soon Do You Need To Sell:</strong></td>
        <td>{{ $sellUrgency ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Do You Currently Live in the House:</strong></td>
        <td>{{ $formDetails->liveInHouse ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Would you like a free home valuation?</strong></td>
        <td>{{ $formDetails->freeValuation ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Would you like to offer a buyer agent commission?:</strong></td>
        <td>{{ $formDetails->offerCommission ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Why Are You Selling?:</strong></td>
        <td>{{ $formDetails->whyAreYouSelling ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>What Type of Property?:</strong></td>
        <td>{{ $formDetails->propertyType ?? '' }}</td>
    </tr>
    @else
    <tr>
        <td><strong>Do you currently Own or Rent?:</strong></td>
        <td>{{ $formDetails->currentlyOwnOrRent ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>What is your timeframe for moving?:</strong></td>
        <td>{{ $formDetails->timeframeForMoving ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>How many bedrooms do you need?:</strong></td>
        <td>{{ $formDetails->numberOfBedrooms ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>How many bathrooms do you need?:</strong></td>
        <td>{{ $formDetails->numberOfBathrooms ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>What is your price range?:</strong></td>
        <td>{{ $formDetails->priceRange ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Have you been preapproved for a mortgage?:</strong></td>
        <td>{{ $formDetails->preapprovedForMontage ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Do you need to sell a home before you buy?:</strong></td>
        <td>{{ $formDetails->sellHomeBeforeBuy ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Is there anything else that will help us find your new home?:</strong></td>
        <td>{{ $formDetails->helpsFindingHomeDesc ?? '' }}</td>
    </tr>
    @endif
</table>
@elseif (in_array($email_type, ["subscription_upgrade"]))
A new lead has been received in your area. Please upgrade your subscription to view the details.
@elseif (in_array($email_type, ["lead_unmatched"]))
A new lead has been received in your area. Please match with some Loan Officer in your area to view the details.
@endif

@component('mail::button', ['url' => $short_url])
@if (in_array($email_type, ["subscription_upgrade"]))
Upgrade Your Subscription
@elseif (in_array($email_type, ["lead_unmatched"]))
Match with Loan Officer
@else
View Details
@endif
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
