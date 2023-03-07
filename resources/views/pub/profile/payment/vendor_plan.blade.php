@extends('pub.profile.layouts.profile')
@section('title') Plans @endsection
@section('page_content')
<div class="panel panel-default">
    <div class="panel-heading">Your Subscription plan</div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item clearfix">
                <div class="pull-left">
                    @if(!empty($plan))
                       <h4>{{ $plan['name'] }}</h4>
                       @if($plan['cost'] != '0.00')
                            <h4>$ {{$plan['cost'] }}</h4>
                       @endif
                       
                        @if(!empty($vendorDetail))
                       @if($vendorDetail[0]->package_selected_state !="")<b>Selected State:</b> {{$vendorDetail[0]->package_selected_state}}<br>@endif
                       @if($vendorDetail[0]->additional_state !="")<b>Additional State:</b> {{implode(',',array_values(json_decode($vendorDetail[0]->additional_state, true)))}}</br>@endif
                       @if($vendorDetail[0]->package_selected_city !="")<b>Selected City:</b> {{$vendorDetail[0]->package_selected_city}}<br>@endif
                       @if($vendorDetail[0]->additional_city !="")<b>Additional City:</b> {{implode(',',array_values(json_decode($vendorDetail[0]->additional_city, true)))}}</br>@endif
                       @endif
                        @if(!empty($prevSubscription))
                        @if(auth()->user()->braintree_id != '6')
                        <b>Total Paid Amount:</b> ${{$prevSubscription[0]->total_amount}}
                        @endif
                        @endif
                        @else
                        @if($subscribe['braintree_plan'] == 'launch-monthly') 
                            <h4>Monthly Lender Membership</h4>
                            <h4>$ 59.00</h4>
                        @elseif($subscribe['braintree_plan'] == 'launch-yearly')
                            <h4>Yearly Lender Membership</h4>
                            <h4>$ 599.00</h4>
                        @endif
                    @endif
                </div>
            </li>
        </ul>
    </div>
</div>
@if(auth()->user()->user_type =='vendor' && auth()->user()->braintree_id !="")
@if(auth()->user()->braintree_id != '12' && auth()->user()->braintree_id != '13'&& auth()->user()->braintree_id != '6')
<div class="panel panel-default">
    <div class="panel-heading">
        Billing Information
    </div>
    <div class="panel-body">
        <a href="{{ route('pub.profile.payment.upgrade-vendor-plan') }}" class="btn btn-warning">Upgrade Plan</a>
    </div>
</div>
@endif
@endif
@endsection