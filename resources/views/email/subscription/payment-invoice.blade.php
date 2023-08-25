@component('mail::message')
<p>Hey {{ ucfirst($user->first_name) }},</p>

<p>Your Payment has been captured successfully. Invoice details are mentioned below.  </p>
<div style="margin-bottom:25px;">
    <h3 style="margin-bottom:5px;">Order Details</h3>
    <table style="border:1px solid #c1c1c1; width:100%; display:inline-block;" cellpadding="0" cellspacing="0">
        <tr>
            <th style="width:16%; border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">S.No.</th>
            <th style="width:44%; border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">Item Name</th>
            <th style="width:20%; border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">Quantity</th>
            <th style="width:20%; border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">Price</th>
        </tr>
        <tr>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">1</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">Monthly {{ ucfirst($user->user_type)}} Membership For ${{ number_format( ($membershipPrice), 2, '.', '') }} USD</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">{{ $subscription->plan->interval_count.' '.$subscription->plan->interval }}</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">${{ number_format( ($membershipPrice), 2, '.', '') }}</td>
        </tr>
        @if( ($subscriptionInvoice->subtotal != $subscriptionInvoice->amount_paid) && isset($subscriptionInvoice->total_discount_amounts))
        <tr>
            <th style="border:1px solid #c1c1c1; padding:5px 10px; text-align:right;" colspan="3">Discount</th>
            <th style="border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">${{ number_format( ($subscriptionInvoice->total_discount_amounts[0]->amount/100), 2, '.', '') }}</th>
        </tr>
        @endif
        <tr>
            <th style="border:1px solid #c1c1c1; padding:5px 10px; text-align:right;" colspan="3">Total</th>
            <th style="border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">${{ number_format( ($subscriptionInvoice->amount_paid/100), 2, '.', '') }}</th>
        </tr>
    </table>
</div>

<div style="margin-bottom:30px;">
    <h3 style="margin-bottom:5px;">Subscription Details</h3>
    <table style="border:1px solid #c1c1c1; width:100%; display:inline-block;" cellpadding="0" cellspacing="0">
        <tr>
            <th style="width:40%; border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">Plan Name</th>
            <th style="width:20%; border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">Satrts From</th>
            <th style="width:20%; border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">Ends On</th>
            <th style="width:20%; border:1px solid #c1c1c1; padding:5px 10px; text-align:left;">Status</th>
        </tr>
        <tr>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">Monthly {{ ucfirst($user->user_type)}} Membership For ${{ number_format( ($membershipPrice), 2, '.', '') }} USD</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">{{ date("m-d-Y", strtotime($user->userSubscription->plan_period_start)) }}</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">{{ date("m-d-Y", strtotime($user->userSubscription->plan_period_end)) }}</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">{{ ucfirst($user->userSubscription->status) }}</td>
        </tr>
    </table>
</div>

<p>Call or text for information at <a href="tel:7045695072">704-569-5072</a></p>

Thank You,<br>
Team {{ config('app.name') }}
@endcomponent