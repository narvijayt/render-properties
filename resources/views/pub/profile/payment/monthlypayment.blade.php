@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('pub.profile.layouts.profile')

@section('title')
@if(auth()->user()->user_type == 'realtor' || auth()->user()->user_type== 'broker')
 @if(auth()->user()->braintree_id != '12')
   Upgrade Account Pay $9 every month
   @else
   You have successfullly upgraded account for $9 every month.
   @endif
   @endif
   
@endsection

@section('page_content')

    @if(session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
            </div>
    @endif
    @if(auth()->user()->user_type == 'realtor' || auth()->user()->user_type== 'broker')
 @if(auth()->user()->braintree_id != '12')
   <div class="panel panel-default">
        <div class="panel-heading">Credit Card Detials</div>
        <div class="panel-body">

            <form method="POST" action="" id="subscription-form">
                <input type="hidden" name="user_id" value="{{$findUser->user_id}}">
                <h6 style="font-size: 15px;">Your information is securely stored on Authorize.net using 256-bit bank grade encryption. {!! get_application_name() !!} does not store credit card information on their servers.</h6>
			    <div class="row">
    				<div class="col-md-6">
    					<h6>Card Number</h6>
    					<input type="number" name="card_num" id="card_num" class="form-control" placeholder="Credit/Debit Card Number" autocomplete="off" required="" aria-required="true">
    				</div>
    				<div class="col-md-6">
    					<h6>Card Expiration Month</h6>
    					<input type="text" name="exp_month" maxlength="2" class="form-control" id="card-expiry-month" placeholder="MM" required="" aria-required="true">
    				</div>
    				<div class="col-md-6" style="margin-bottom:34px;">
    					<h6>Card Expiration Year</h6>
    					<input type="text" name="exp_year" maxlength="4" class="form-control" id="card-expiry-year" placeholder="YYYY" required="" aria-required="true">
    				</div>
    				<div class="col-md-6">
    					<h6>CVC Code</h6>
    					<input type="text" name="cvc" id="card-cvc" maxlength="4" class="form-control" autocomplete="off" placeholder="CVC" required="" aria-required="true">
    				</div>
    				<input type="hidden" name="payment_transaction_id" value="{{ old('payment_transaction_id', (isset($user->payment_transaction_id) ? $user->payment_transaction_id : '')) }}">
				</div>
				 <hr>
				 {{ csrf_field() }}
				<button id="" class="btn btn-warning btn-flat " type="submit">Upgrade Account</button>
            </form>
        </div>
    </div>
    @endif
    @endif
@endsection

@push('scripts-footer')
    <script src="https://js.braintreegateway.com/web/dropin/1.7.0/js/dropin.min.js"></script>
    <script>
@endpush