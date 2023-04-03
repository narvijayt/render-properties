@component('mail::message')
# {{ $user->first_name }} your subscription has changed

You current plan: {{ $plan->name }}

Cost: ${{ number_format($plan->cost, 2) }}

@component('mail::button', ['url' => route('pub.profile.payment.index')])
Manage Your Subscription
@endcomponent

Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent
