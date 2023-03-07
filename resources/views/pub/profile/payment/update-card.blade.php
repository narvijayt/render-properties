@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('pub.profile.layouts.profile')
@section('title') Change Billing @endsection
@section('page_content')
    <div class="panel panel-default">
        <div class="panel-heading">Billing Information</div>
        <div class="panel-body">

            <form method="POST" action="{{ route('pub.profile.payment.update-card-store') }}" id="subscription-form">


                <div class="form-group {{ $errors->has('billing_first_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_first_name">
                        @if($errors->has('billing_first_name'))<i class="fa fa-times-circle-o"></i>@endif First Name
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="First Name"
                            name="billing_first_name"
                            value="{{ old('billing_first_name', (isset($user->billing_first_name) ? $user->billing_first_name : '')) }}">
                    @if($errors->has('billing_first_name'))
                        <span class="help-block">{{ $errors->first('billing_first_name') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('billing_last_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_last_name">
                        @if($errors->has('billing_last_name'))<i class="fa fa-times-circle-o"></i>@endif Last Name
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="Last Name"
                            name="billing_last_name"
                            value="{{ old('billing_last_name', (isset($user->billing_last_name) ? $user->billing_last_name : '')) }}">
                    @if($errors->has('billing_last_name'))
                        <span class="help-block">{{ $errors->first('billing_last_name') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('billing_company') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_company">
                        @if($errors->has('billing_company'))<i class="fa fa-times-circle-o"></i>@endif Company
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="Company"
                            name="billing_company"
                            value="{{ old('billing_company', (isset($user->billing_company) ? $user->billing_company : '')) }}">
                    @if($errors->has('billing_company'))
                        <span class="help-block">{{ $errors->first('billing_company') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('billing_address_1') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_address_1">
                        @if($errors->has('billing_address_1'))<i class="fa fa-times-circle-o"></i>@endif Address 1
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="Billing Address 1"
                            name="billing_address_1"
                            value="{{ old('billing_address_1', (isset($user->billing_address_1) ? $user->billing_address_1 : '')) }}">
                    @if($errors->has('billing_address_1'))
                        <span class="help-block">{{ $errors->first('billing_address_1') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('billing_address_2') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_address_2">
                        @if($errors->has('billing_address_2'))<i class="fa fa-times-circle-o"></i>@endif Address 2
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="Billing Address 2"
                            name="billing_address_2"
                            value="{{ old('billing_address_2', (isset($user->billing_address_2) ? $user->billing_address_2 : '')) }}">
                    @if($errors->has('billing_address_2'))
                        <span class="help-block">{{ $errors->first('billing_address_2') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('billing_locality') ? 'has-error' : '' }}">
                    <label class="control-label" for="billing_locality">
                        @if($errors->has('billing_locality'))<i class="fa fa-times-circle-o"></i>@endif City
                    </label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="City"
                            name="billing_locality"
                            value="{{ old('billing_locality', (isset($user->billing_locality) ? $user->billing_locality : '')) }}">
                    @if($errors->has('billing_locality'))
                        <span class="help-block">{{ $errors->first('billing_locality') }}</span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-7">

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
                    <div class="col-md-5">

                        <div class="form-group {{ $errors->has('billing_postal_code') ? 'has-error' : '' }}">
                            <label class="control-label" for="billing_postal_code">
                                @if($errors->has('billing_postal_code'))<i class="fa fa-times-circle-o"></i>@endif Zip
                            </label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter Username"
                                    name="billing_postal_code"
                                    value="{{ old('billing_postal_code', (isset($user->billing_postal_code) ? $user->billing_postal_code : '')) }}">
                            @if($errors->has('billing_postal_code'))
                                <span class="help-block">{{ $errors->first('billing_postal_code') }}</span>
                            @endif
                        </div>

                    </div>
                </div>

                <div id="dropin-container"></div>
                <hr>
                <input type="hidden" id="nonce" name="nonce" value="">
                {{ csrf_field() }}
                <button id="payment-button" class="btn btn-warning btn-flat hidden" type="submit">Update Information</button>
            </form>

        </div>
    </div>
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
@endpush