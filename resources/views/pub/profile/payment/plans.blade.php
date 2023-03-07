@extends('pub.profile.layouts.profile')
@section('title') Plans | Edit Profile @endsection
@section('meta')
    {{ meta('description', config('seo.description')) }}
    {{ meta('keywords', config('seo.keyword')) }}
@endsection

@section('page_content')
<div class="panel panel-default">
    <div class="panel-heading">Your Subscription plan</div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item clearfix">
                <div class="pull-left">
                    @if(!empty($plan))
                     <!--- <div class="alert alert-success">During this time of crisis. Render stands with our members. 
                      Until further notice all membership monthly payments will be waived at this time.</div>-->
                        <h4>{{ $plan['name'] }}</h4>
                        
                        @if($plan['cost'] != '0.00')
                            <h4>$ {{$plan['cost'] }}</h4>
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

@endsection