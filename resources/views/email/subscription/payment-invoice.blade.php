@component('mail::message')
<p>Hey {{ ucfirst($user->first_name) }},</p>

<p>Your Payment has been captured successfully. Invoice details mentioned below.  </p>

<h3>Order Details</h3>
<table>
    <tr>
        <td>S.No.</td>
        <td>Item Name</td>
        <td>Quantity</td>
        <td>Price</td>
    </tr>
    <tr>
        <td>1</td>
        <td>Monthly Lender Membership For $19.80 USD</td>
        <td>1 Month</td>
        <td>$19.80</td>
    </tr>
    <tr>
        <td colspan="3">Total</td>
        <td>$19.80</td>
    </tr>
</table>

<h3>Subscription Details</h3>
<table>
    <tr>
        <td>Plan Name</td>
        <td>Satrts From</td>
        <td>Ends On</td>
        <td>Status</td>
    </tr>
    <tr>
        <td>Monthly Lender Membership For $19.80 USD</td>
        <td>{{ date("d-m-Y", strtotime($user->userSubscription->plan_period_start)) }}</td>
        <td>{{ date("d-m-Y", strtotime($user->userSubscription->plan_period_end)) }}</td>
        <td>{{ ucfirst($user->userSubscription->status) }}</td>
    </tr>
</table>

Thank You,<br>
Team {{ config('app.name') }}
@endcomponent