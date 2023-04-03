@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('pub.profile.layouts.profile')
@section('title') Upgrade Plan @endsection
@section('page_content')
 <form method="POST" action="{{ route('pub.profile.payment.vendor-plan-upgrade') }}" id="subscription-form">
     @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
             @if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
         @endif
           
@if($plan !="")


  <div class="panel panel-default">
    <div class="panel-heading">Current Subscription plan</div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item clearfix">
                <div class="pull-left">
                    @if(!empty($plan))
                    <h4> {{ $plan['name'] }} </h4>
                        @if($plan['cost'] != '0.00')
                            <h4>$ {{$plan['cost'] }}</h4>
                        @endif
                        
                   @endif
                </div>
                <div class="pull-right">
                    @if(!empty($vendorDetails))
                        @if($vendorDetails[0]->package_selected_state !="")<b>Selected State:</b> {{$vendorDetails[0]->package_selected_state}}<br>@endif 
                        @if($vendorDetails[0]->additional_state !="")<b>Additional States:</b>{{implode(',',array_values(json_decode($vendorDetails[0]->additional_state, true)))}} <br>@endif 
                        @if($vendorDetails[0]->package_selected_city !="")<b>Selected City:</b> {{$vendorDetails[0]->package_selected_city}} <br>@endif 
                        @if($vendorDetails[0]->additional_city !="")<b>Additional City:</b> {{implode(',',array_values(json_decode($vendorDetails[0]->additional_city, true)))}} <br>@endif 
                         @if($vendorDetails[0]->payable_amount !="")<b>Paid Amount:</b> ${{$vendorDetails[0]->payable_amount}} <br>@endif 
                         <input type="hidden" id="prev_plan_amount" value="{{$vendorDetails[0]->payable_amount}}">
                        @endif
                    
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Upgrade Subscription plan</div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item clearfix">
                <div class="pull-center">
                   @if($plan['braintree_plan_id'] == '7' || $plan['braintree_plan_id'] == '8' )
              	 <table class="table">
            		  <thead>
            		     <tr><th>Description</th><th>Amount</th></tr>
            		    </thead>
            			<tbody style="text-align:left;">
            		    <tbody id="additionalFields"></tbody>
            			<tr><td>Add More Additional City for <strong>$79</strong> <u>MO</u> <small>EACH ADDITIONAL*</small></td><td><button type="button" class="btn btn-success" id="addMoreCity"><i class="fa fa-plus"></i></button></td></tr>	  
            		 </tbody>
            		 <tfoot style="text-align:left;">
            		     <tr><th>Total</th><th id="totalPrice">$99</th></tr>
            		    </tfoot>
            		  </table>
            		  <input type="hidden" id="current_city" name="curr_city" value="">
                     @endif
                     @if($plan['braintree_plan_id'] == '9' || $plan['braintree_plan_id'] == '10')
                      <table class="table">
		  <thead>
		     <tr><th>Description</th><th>Amount</th></tr>
		    </thead>
			<tbody style="text-align:left;">
		    	<tbody id="additionalStateFields"></tbody>
			<tr><td>Add More Additional State for <strong>$599</strong> <u>MO</u> <small>EACH ADDITIONAL*</small></td><td><button type="button" class="btn btn-success" id="addmorBtn"><i class="fa fa-plus"></i></button></td></tr>	  
		 </tbody>
		 <tfoot style="text-align:left;">
		     <tr><th>Total</th><th id="totalStatePrice">$799</th></tr>
		    </tfoot>
		  </table>
		    <input type="hidden" id="current_state" name="curr_state" value="">
                     @endif
                      @if($plan['braintree_plan_id'] == '11')
		<table class="table">
		  <thead>
		     <tr><th>Description</th><th>Amount</th></tr>
		    </thead>
			<tbody style="text-align:left;">
		     <tr><td>UNITED STATES <small>(FOR ONE MONTH*)</small>
		     <input type="hidden" name="selected_us" value="11">
			      </td><td>$8995 MO</u></td></tr>
			<tbody id="additionalStateFields"></tbody>
			<tr><td><strong>OWN THE U.S. IN YOUR INDUSTRY!!!</strong></td></tr>	  
		 </tbody>
		 <tfoot style="text-align:left;">
		     <tr><th>Total</th><th id="totalStatePrice">$8995</th></tr>
		    </tfoot>
		  </table>
	  @endif
                </div>
            </li>
        </ul>
    </div>
</div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">Billing Infomation</div>
    <div class="panel-body">
 <div class="col-md-6 form-group {{ $errors->has('billing_first_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_first_name">
                        @if($errors->has('billing_first_name'))<i class="fa fa-times-circle-o"></i>@endif First Name
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="First Name"
                            name="billing_first_name"
                            value="{{ old('billing_first_name', (isset($user->billing_first_name) ? $user->billing_first_name : '')) }}" required="" aria-required="true">
                    @if($errors->has('billing_first_name'))
                        <span class="help-block">{{ $errors->first('billing_first_name') }}</span>
                    @endif
                </div>

                <div class="col-md-6 form-group {{ $errors->has('billing_last_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_last_name">
                        @if($errors->has('billing_last_name'))<i class="fa fa-times-circle-o"></i>@endif Last Name
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="Last Name"
                            name="billing_last_name"
                            value="{{ old('billing_last_name', (isset($user->billing_last_name) ? $user->billing_last_name : '')) }}" required="" aria-required="true">
                    @if($errors->has('billing_last_name'))
                        <span class="help-block">{{ $errors->first('billing_last_name') }}</span>
                    @endif
                </div>
                <div class="col-md-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" name="email" value="{{ old('email', (isset($user->email) ? $user->email : '')) }}" required="" aria-required="true" />
               @if($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="col-md-6 form-group {{ $errors->has('billing_company') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_company">
                        @if($errors->has('billing_company'))<i class="fa fa-times-circle-o"></i>@endif Company
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="Company"
                            name="billing_company"
                            value="{{ old('billing_company', (isset($user->billing_company) ? $user->billing_company : '')) }}" required="" aria-required="true">
                    @if($errors->has('billing_company'))
                        <span class="help-block">{{ $errors->first('billing_company') }}</span>
                    @endif
                </div>

                <div class="col-md-6 form-group {{ $errors->has('billing_address_1') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_address_1">
                        @if($errors->has('billing_address_1'))<i class="fa fa-times-circle-o"></i>@endif Address 1
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="Billing Address 1"
                            name="billing_address_1"
                            value="{{ old('billing_address_1', (isset($user->billing_address_1) ? $user->billing_address_1 : '')) }}" required="" aria-required="true">
                    @if($errors->has('billing_address_1'))
                        <span class="help-block">{{ $errors->first('billing_address_1') }}</span>
                    @endif
                </div>

                <div class="col-md-6 form-group {{ $errors->has('billing_address_2') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_address_2">
                        @if($errors->has('billing_address_2'))<i class="fa fa-times-circle-o"></i>@endif Address 2
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="Billing Address 2"
                            name="billing_address_2"
                            value="{{ old('billing_address_2', (isset($user->billing_address_2) ? $user->billing_address_2 : '')) }}" required="" aria-required="true">
                    @if($errors->has('billing_address_2'))
                        <span class="help-block">{{ $errors->first('billing_address_2') }}</span>
                    @endif
                </div>

                

                <div class="row">
                    <div class="col-md-4 form-group {{ $errors->has('billing_locality') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_locality">
                        @if($errors->has('billing_locality'))<i class="fa fa-times-circle-o"></i>@endif City
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="City"
                            name="billing_locality"
                            value="{{ old('billing_locality', (isset($user->billing_locality) ? $user->billing_locality : '')) }}" required="" aria-required="true">
                    @if($errors->has('billing_locality'))
                        <span class="help-block">{{ $errors->first('billing_locality') }}</span>
                    @endif
                </div>
                    <div class="col-md-4">

                        <div class="form-group{{ $errors->has('billing_region') ? ' has-error' : '' }}">
                            <label for="billing_region" class="control-label">State</label>
                            <select class="form-control" name="billing_region" required>
                                <option value="">Choose a state</option>
                                @foreach($states::all() as $abbr => $stateName)
                                    <option value="{{ $abbr }}" {{
                                        collect(old('billing_region', (isset($user->billing_region) ? $user->billing_region : null)))->contains($abbr) ? 'selected' : ''
                                    }}>{{ $stateName }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('billing_region'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('billing_region') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="form-group {{ $errors->has('billing_postal_code') ? 'has-error' : '' }}">
                            <label class="control-label" for="billing_postal_code">
                                @if($errors->has('billing_postal_code'))<i class="fa fa-times-circle-o"></i>@endif Zip
                            </label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter Username"
                                    name="billing_postal_code"
                                    value="{{ old('billing_postal_code', (isset($user->billing_postal_code) ? $user->billing_postal_code : '')) }}" required="" aria-required="true">
                            @if($errors->has('billing_postal_code'))
                                <span class="help-block">{{ $errors->first('billing_postal_code') }}</span>
                            @endif
                        </div>

                    </div>
                </div>
                </div>
                </div>
                
                
                
                

   <div class="panel panel-default">
     <div class="panel-body">
                 @if($plan !="")
                <input type="hidden" id="prev_brainId" name="previous_braintree_id" value="{{$plan['braintree_plan_id']}}">
                @endif
                <input type="hidden" name="prev_subscription_id"value="{{auth()->user()->payment_transaction_id}}">
                <!---<div id="dropin-container"></div>-->
                <input type="hidden" name="user_id" value="{{auth()->user()->user_id}}">
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
                <input type="hidden" id="nonce" name="nonce" value="">
                {{ csrf_field() }}
                <button id="" class="btn btn-warning btn-flat " type="submit">Upgrade Account</button>
         </div>
    </div>
       </form>
@endsection

@push('scripts-footer')
    <script src="https://js.braintreegateway.com/web/dropin/1.7.0/js/dropin.min.js"></script>
    <script>

		var button = document.getElementById('payment-button')
		var form = document.getElementById('subscription-form')
		var nonceInput = document.getElementById('nonce')

		var setupBraintree = function (token) {
			button.classList.remove('hidden')
			braintree.dropin.create({
				authorization: token,
				container: '#dropin-container'
			}, function(createErr, instance) {
				button.addEventListener('click', function(e) {
					e.preventDefault()
                    button.disabled = true
					instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
                        if (requestPaymentMethodErr) {
                        	button.disabled = false
							Flash({
                                message: 'An error occurred trying to process your payment method',
                                level: 'error',
							})
                        } else {
							submitPayment(payload)
                        }
					})
				})
			})
		}

		var submitPayment = function(nonce) {
			console.log(nonce)
			nonceInput.value = nonce.nonce
			form.submit()
		}

		axios.get('{{ route('pub.profile.payment.token') }}')
			.then(function(response) {
				setupBraintree(response.data.data.token)
			})
    </script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
   
    /*********State Package Option ****************************/  
    var stateCounter = 0;
    $('#subscription-form').on('click', '#addmorBtn', function() 
    {
    $('#additionalStateFields').append('<tr id="row'+stateCounter+'"><td ><div class="odd gradeX" >'+'<input type="text" id="add_additionalState' + stateCounter + '" name="additional_state[' + stateCounter + ']' + '" placeholder="Enter Additional State" class="form-control" pattern="^[A-Za-z -]+$" required/>'+'</div> </td><td>'+
            '<button type="button" name="remove" id="'+stateCounter+'" class="btn btn-warning btn_removestate"><i class="fa fa-close"></i></button></td></tr>');
        var previousPlan = $('#prev_plan_amount').val();
        var initialCount = 599 + parseInt(previousPlan);
        var addiStateAmount = 599;
        if(stateCounter == 0)
        {
            $('#current_state').val(initialCount);
            $('#totalStatePrice').html('$'+initialCount);
        }else{
            var stateVal = $('#current_state').val();
            var additionalStateVal = parseInt(stateVal)+parseInt(addiStateAmount);
            $('#current_state').val(additionalStateVal);
            $('#totalStatePrice').html('$'+additionalStateVal);
        }
         ++stateCounter;
       });
      $(document).on('click', '.btn_removestate', function()
      {  
      if (confirm('Are you sure you want to delete this Additional State Name?'))
      {
          var button_id = $(this).attr("id");   
          $('#row'+button_id+'').remove();  
          var initialAmount = 599;
          var itrDeduction = 599;
          var stateAmount = $('#current_state').val();
          var stateAddDeduction = parseInt(stateAmount)-parseInt(itrDeduction);
          $('#current_state').val(stateAddDeduction);
          $('#totalStatePrice').html('$'+stateAddDeduction);
      }
    }); 
  /********************End State Package Option**************/
    /*******************City Package Option*******************/
     var itr = 0;
    $('#subscription-form').on('click', '#addMoreCity', function() 
    {
         $('#totalPrice').empty();
        $('#additionalFields').append('<tr id="row'+itr+'"><td ><div class="odd gradeX">'+'<input type="text" id="add_additionalCity' + itr + '" name="additional_city[' + itr + ']' + '" placeholder="Enter Additional City" class="form-control" pattern="^[A-Za-z -]+$" required/>'+'</div> </td><td>'+
            '<button type="button" name="remove" id="'+itr+'" class="btn btn-warning btn_remove"><i class="fa fa-close"></i></button></td></tr>');
         var previousAmount = $('#prev_plan_amount').val();
         var firstItr = 79 + parseInt(previousAmount);
         var addPrice = 79;
         if(itr == 0)
         {
             $('#current_city').val(firstItr);
             $('#totalPrice').html('$'+firstItr);
         }else{
             var cityVal = $('#current_city').val();
             var addItr =   parseInt(cityVal)+parseInt(addPrice);
             $('#current_city').val(addItr);
             $('#totalPrice').html('$'+addItr);
         }
         ++itr;
       });
      $(document).on('click', '.btn_remove', function()
      {  
      if (confirm('Are you sure you want to delete this Additional City Name?'))
      {
         var button_id = $(this).attr("id");   
         $('#row'+button_id+'').remove();
         var initalVal = 79;
         var deductionAmount = 79;
          var currAmnt = $('#current_city').val();
          var AddDeductionAmount =   parseInt(currAmnt)-parseInt(deductionAmount);
          $('#current_city').val(AddDeductionAmount);
          $('#totalPrice').html('$'+AddDeductionAmount);
     }
    }); 
    
    $( document ).ready(function() {
        var brainTreeId = $('#prev_brainId').val();
        if(brainTreeId == '10' || brainTreeId == '9'){
            $('#addmorBtn').click();
        }
         if(brainTreeId == '7' || brainTreeId == '8'){
            $('#addMoreCity').click();
        }
    });
    /**********************End City Package Option**************/
    </script>
 
@endpush
