@component('mail::message', ['formDetails' => $formDetails])

<table style="background-color: #eee; padding: 15px;">
    <tr>
        <td style="color: #000; padding-bottom: 5px;">
            <strong>Hi {{ $user_name }},</strong>
        </td>
    </tr>
    
    @if ($email_type === "detailed_with_no_broker_found")
        <tr>
            <td colspan="2" style="color: #000; padding-bottom: 10px;">
                There is no LO found in this state.
            </td>
        </tr>
    @elseif (in_array($email_type, ["detailed_with_paid_loan_officer"]))
        <tr>
            <td colspan="2" style="color: #000; padding-bottom: 10px;">
                A new lead has been received in your area. Here are the details:
            </td>
        </tr>
    @endif

    @if (in_array($email_type, ["detailed_with_paid_loan_officer", "detailed_with_no_broker_found"]))
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
            <td style="color: #000; padding: 5px;">{{ $formDetails->phone_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Street Address:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->street_address ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Street Address Line 2:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->street_address_line_2 ?? 'N/A' }}</td>
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
        <tr>
            <td style="color: #000; padding: 5px;"><strong>What type of property you are refinancing?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->type_of_property ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Estimate your credit score:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->estimate_credit_score ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>How will this property be used?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->how_property_used ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Do you have second mortgage?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->have_second_mortgage ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Would you like to borrow additional cash?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ '$' . $formDetails->borrow_additional_cash ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>What is your employment status?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->employment_status ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Bankruptcy, short sale, or foreclosure in the last 3 years?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->bankruptcy_shortscale_foreclosure ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Can you show proof of income?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->proof_of_income ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>What is your average monthly income?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ '$' . $formDetails->average_monthly_income ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>What are your average monthly expenses?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ '$' . $formDetails->average_monthly_expenses ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="color: #000; padding: 5px;"><strong>Do you currently have an FHA loan?:</strong></td>
            <td style="color: #000; padding: 5px;">{{ $formDetails->currently_have_fha_loan ?? 'N/A' }}</td>
        </tr>

    @elseif (in_array($email_type, ["subscription_upgrade"]))
        <tr>
            <td style="color: #000; padding: 5px 0px;">A new lead has been received in your area. Please upgrade your subscription to view the details.</td>
        </tr>
    @endif

    <tr>
        <td>
            <a href="{{ $short_url }}">
                <button style="background-color: #F79A2C; border: none; color: #184586; padding: 12px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; font-weight: bold; margin: 10px 0px 10px 0px; text-transform: uppercase; cursor:pointer;">
                    @if (in_array($email_type, ["subscription_upgrade"]))
                        Upgrade Your Subscription
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
