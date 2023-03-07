@extends('pub.profile.layouts.profile')
@section('title') Change Subscription @endsection
@section('page_content')

    <div class="panel panel-default">
        <div class="panel-heading">Choose your plan</div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach($plans as $plan)
                    <li class="list-group-item clearfix">
                        <div class="pull-left">
                            <h4>{{ $plan->name }}</h4>
                            <h4>${{ number_format($plan->cost, 2) }}</h4>
                            @if ($plan->description)
                                <p>{{ $plan->description }}</p>
                            @endif
                        </div>

                        @if($subscription->braintree_plan === $plan->braintree_plan)
                            <button class="btn btn-warning disabled pull-right" disabled>Already Subscribed</button>
                        @else
                            <form method="POST" action="{{ route('pub.profile.payment.change-subscription-store') }}" class="pull-right">
                                <input type="hidden" name="plan_id" value="{{ $plan->braintree_plan }}">
                                {{ csrf_field() }}
                                <button class="btn btn-warning ">Choose Plan</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection