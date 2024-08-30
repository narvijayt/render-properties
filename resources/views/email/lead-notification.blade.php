@component('mail::message', ['formDetails' => $formDetails])

<table style="background-color: #eee; padding: 15px;">
    <tr>
        <td style="color: #000; padding-bottom: 5px;">
            <strong>Hi {{ $user_name }},</strong>
        </td>
    </tr>
    
    @if ($email_type === "detailed_with_neither_realtor_nor_broker_found")
        <tr>
            <td colspan="2" style="color: #000; padding-bottom: 10px;">
                There is no LO and REA found in this area.
            </td>
        </tr>
    @elseif ($email_type === "detailed_with_no_realtor_found")
        <tr>
            <td colspan="2" style="color: #000; padding-bottom: 10px;">
                There is no REA found in this area.
            </td>
        </tr>
    @elseif ($email_type === "detailed_with_no_broker_found")
        <tr>
            <td colspan="2" style="color: #000; padding-bottom: 10px;">
                There is no LO found in this area.
            </td>
        </tr>
    @elseif (in_array($email_type, ["detailed", "detailed_with_lead_matched"]))
        <tr>
            <td colspan="2" style="color: #000; padding-bottom: 10px;">
                A new lead has been received in your area. Here are the details:
            </td>
        </tr>
    @endif

    @if (in_array($email_type, ["detailed_with_neither_realtor_nor_broker_found", "detailed_with_no_realtor_found", "detailed_with_no_broker_found", "detailed", "detailed_with_lead_matched"]))
        @php
            $timeToContact = $formDetails->formPropertyType === "sell" ? implode(", ", json_decode($formDetails->timeToContact, true)) : '';
            $sellUrgency = $formDetails->formPropertyType === "sell" ? implode(", ", json_decode($formDetails->sellUrgency, true)) : '';
        @endphp
        <tr>
            <td style="color: #000; padding: 5px;"><strong>First Name:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->firstName ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Last Name:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->lastName ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Email:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->email ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Phone Number:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->phoneNumber ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Street Address:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->streetAddress ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Street Address Line 2:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->streetAddressLine2 ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>City:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->city ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>State:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->state ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Postal Code:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->postal_code ?? 'N/A' }}</td>
        </tr>

        @if ($formDetails->formPropertyType === "sell")
            <tr>
                <td style="color: #000; padding: 5px;"><strong>Best Time To Contact You:</strong></td>
                <td style="color: #000; padding: 5px;">{{ $timeToContact ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>How Soon Do You Need To Sell:</strong></td>
                <td style="color: #000; padding: 5px;">{{ $sellUrgency ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>Do You Currently Live in the House:</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->liveInHouse ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>Would you like a free home valuation?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->freeValuation ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>Would you like to offer a buyer agent commission?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->offerCommission ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>Why Are You Selling?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->whyAreYouSelling ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>What Type of Property?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->propertyType ?? 'N/A' }}</td>
            </tr>
        @else
            <tr>
                <td style="color: #000; padding: 5px;"><strong>Do you currently Own or Rent?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->currentlyOwnOrRent ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>What is your timeframe for moving?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->timeframeForMoving ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>How many bedrooms do you need?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->numberOfBedrooms ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>How many bathrooms do you need?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->numberOfBathrooms ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>What is your price range?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->priceRange ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>Have you been preapproved for a mortgage?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->preapprovedForMontage ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="color: #000; padding: 5px;"><strong>Do you need to sell a home before you buy?</strong></td>
                <td style="color: #000; padding: 5px;">{{ $formDetails->sellHomeBeforeBuy ?? 'N/A' }}</td>
            </tr>
        @endif

    @elseif (in_array($email_type, ["subscription_upgrade"]))
        <tr>
            <td style="color: #000; padding: 5px 0px;">A new lead has been received in your area. Please upgrade your subscription to view the details.</td>
        </tr>
    @elseif (in_array($email_type, ["lead_unmatched"]))
        <tr>
            <td style="color: #000; padding: 5px 0px;">A new lead has been received in your area. Please match with a Loan Officer in your area to view the details.</td>
        </tr>
    @endif

    <tr>
        <td>
            <a href="{{ $short_url }}">
                <button style="background-color: #F79A2C; border: none; color: #184586; padding: 12px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; font-weight: bold; margin: 10px 0px 10px 0px; text-transform: uppercase; cursor:pointer;">
                    @if (in_array($email_type, ["subscription_upgrade"]))
                        Upgrade Your Subscription
                    @elseif (in_array($email_type, ["lead_unmatched"]))
                        Match with Loan Officer
                    @else
                        View Details
                    @endif
                </button>
            </a>
        </td>
    </tr>
    
    <tr>
        <td colspan="2" style="color: #000; padding-top: 15px; font-weight: bold;">
            Thanks,<br>
            {{ config('app.name') }}
        </td>
    </tr>
    
</table>

@endcomponent
