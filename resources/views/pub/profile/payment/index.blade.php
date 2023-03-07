@extends('pub.profile.layouts.profile')
<?php /** @var $user \App\User */ ?>

@section('title')
    Billing Info
@endsection

@section('page_content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Subscription Details
        </div>
        <div class="panel-body">
            @if($user->isPrepaidCustomer() && $user->isPayingCustomer())
                <p>Your account is prepaid through {{ $user->prepaid_period_ends_at->format('l F j, Y') }}</p>
            @endif
            @if (!$user->subscribed('main'))
                <p>You are not subscribed to a recurring plan. <a href="{{ route('pub.profile.payment.plans') }}">Subscribe Now</a></p>
            @else
				<?php
				$subscriptionPlan = $user->subscriptionPlan();
				?>
                <div class="">
                    <p><strong>{{ $subscriptionPlan->name }}</strong>
                        @if($subscription->active() && !$subscription->cancelled())
                            <span class="label label-success">Active</span>
                        @elseif($subscription->active() && $subscription->cancelled())
                            <span class="label label-warning">Pending Cancellation</span>
                        @else
                            <span class="label label-danger">Inactive</span>
                        @endif
                        <br/>
                        <p>{{ $subscriptionPlan->description }}</p>
                        Total: ${{ number_format($subscriptionPlan->cost, 2) }}<br/>
                        Billing Cycle: {{ $subscriptionPlan->frequency() }}</p>
                </div>

                <div class="clearfix">
                    @if($subscription->active() && !$subscription->cancelled())
                        <a href="{{ route('pub.profile.payment.change-subscription-show') }}" class="btn btn-warning">Change</a>

                        <form action="{{ route('pub.profile.payment.cancel-subscription') }}" method="POST"
                              class="pull-right">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </form>
                    @elseif($subscription->active() && $subscription->cancelled())
                        <form action="{{ route('pub.profile.payment.resume-subscription') }}" method="POST" class="">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success">Resume Subscription</button>
                        </form>
                    @else
                        create new
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if($user->subscribed('main'))
        <div class="panel panel-default">
            <div class="panel-heading">
                Billing Information
            </div>
            <div class="panel-body">
                <a href="{{ route('pub.profile.payment.update-card-show') }}" class="btn btn-warning">Update Billing
                    Information</a>
            </div>
        </div>
    @endif

    @if($user->braintree_id)
        <div class="panel panel-default">
            <div class="panel-heading">
                Invoices
            </div>
            <div class="panel-body">
                @php
                    $invoices = $user->invoicesIncludingPending()
                @endphp

                @if($invoices->count() === 0)
                    You have no invoices.
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php /** @var \Laravel\Cashier\Invoice $invoice */ ?>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->asBraintreeTransaction()->createdAt->format('F j, Y') }}</td>
                                <td>{{ $invoice->total() }}</td>
                                <td><a href="{{ route('pub.profile.payment.download-invoice', $invoice->id) }}">Download
                                        PDF</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endif
@endsection
