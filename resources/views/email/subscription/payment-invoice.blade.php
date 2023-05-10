@component('mail::message')
<p>Hey {{ ucfirst($user->first_name) }},</p>

<p>Your Payment has been captured successfully. Invoice details mentioned below.  </p>
<div style="margin-bottom:15px;">
    <h3 style="margin-bottom:5px;">Order Details</h3>
    <table style="border:1px solid #c1c1c1; width:100%; display:inline-block;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:16%; border:1px solid #c1c1c1; padding:5px 10px;">S.No.</td>
            <td style="width:44%; border:1px solid #c1c1c1; padding:5px 10px;">Item Name</td>
            <td style="width:20%; border:1px solid #c1c1c1; padding:5px 10px;">Quantity</td>
            <td style="width:20%; border:1px solid #c1c1c1; padding:5px 10px;">Price</td>
        </tr>
        <tr>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">1</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">Monthly Lender Membership For $19.80 USD</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">1 Month</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">$19.80</td>
        </tr>
        <tr>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;" colspan="3">Total</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">$19.80</td>
        </tr>
    </table>
</div>

<div style="margin-bottom:30px;">
    <h3 style="margin-bottom:5px;">Subscription Details</h3>
    <table style="border:1px solid #c1c1c1; width:100%; display:inline-block;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:40%; border:1px solid #c1c1c1; padding:5px 10px;">Plan Name</td>
            <td style="width:20%; border:1px solid #c1c1c1; padding:5px 10px;">Satrts From</td>
            <td style="width:20%; border:1px solid #c1c1c1; padding:5px 10px;">Ends On</td>
            <td style="width:20%; border:1px solid #c1c1c1; padding:5px 10px;">Status</td>
        </tr>
        <tr>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">Monthly Lender Membership For $19.80 USD</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">{{ date("d-m-Y", strtotime($user->userSubscription->plan_period_start)) }}</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">{{ date("d-m-Y", strtotime($user->userSubscription->plan_period_end)) }}</td>
            <td style="border:1px solid #c1c1c1; padding:5px 10px;">{{ ucfirst($user->userSubscription->status) }}</td>
        </tr>
    </table>
</div>
Thank You,<br>
Team {{ config('app.name') }}
@endcomponent