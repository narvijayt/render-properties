@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')
@section('title', 'Payment Package')
@section('meta')
    @php
        $description = 'Register for Render'
    @endphp
    {{ meta('description', $description) }}
    {{ meta('keywords', config('seo.keyword')) }}
    {{ openGraph('og:title', 'Register') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}

    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Register') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}

    {{ googlePlus('name', 'Register') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection
@section('content')
    @component('pub.components.banner', ['banner_class' => 'lender'])
        Payment Package
    @endcomponent
  
    <style>.banner{margin:0}.footer{margin-top:0}</style> 
    <section class="bg-grey py-3">
        <div class="container">
            <div class="row">
                @if(session()->has('message'))
                    <div class="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif
             
                <form class="lender-ragistration" id="lender-ragistration" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-6 p-0 vendor-billingInfo">
                        <div class="vendor-reg-box">
                            <div class="box-title-box">
                                <h1 class="box-title line-left family-mont">Billing Details</h1>
                            </div>
                            <input type="hidden" name="user_id" value="{{$userDetails->user_id}}" /> 
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="first_name">First Name</label>
                                        <input type="text" id="first_name" class="form-control" name="first_name" value="{{$userDetails->first_name}}" required="" aria-required="true" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" id="last_name" class="form-control" name="last_name" value="{{$userDetails->last_name}}" required="" aria-required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control" name="email" value="{{$userDetails->email}}" required="" aria-required="true" />
                                </div>
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <input type="text" id="company" class="form-control" name="firm_name" value="{{$userDetails->firm_name}}"/>
                                </div>
                                <div class="clearfix"></div>
                                <!--<div class="form-group">-->
                                <!--    <label for="address1">Billing Address1</label>-->
                                <!--    <input type="text" id="address1" class="form-control" name="address" placeholder="Billing Address 1" value="{{$userDetails->billing_address_1}}" required="" aria-required="true"/>-->
                                <!--</div>-->
                                <!--<div class="form-group">-->
                                <!--    <label for="address2">Billing Address2</label>-->
                                <!--    <input type="text" id="address2" class="form-control" name="address2" placeholder="Billing Address 2" value="{{$userDetails->billing_address_2}}"/>-->
                                <!--</div>-->
                                <div class="row">
                                 <div class="form-group col-md-4">
                                     <label for="billing_locality">City</label>
                                    <input type="text" id="billing_locality" class="form-control" placeholder="City" name="city" value="{{$userDetails->city}}" required="" aria-required="true"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="billing_region">State</label>
                                    <input type="text" id="billing_region" class="form-control" name="state" placeholder="State" value="{{$userDetails->state}}" required="" aria-required="true"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="billing_postal_code">Zip</label>
                                    <input type="text" id="billing_postal_code" class="form-control" name="zip" placeholder="Postal Code" value="{{$userDetails->zip}}"  required="" aria-required="true"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-6 p-0">
                        <div class="card-form package-infobox">
                            <div class="row"> 
                                <div class="col-md-12">
                                    <h4>Subscription</h4>
                                    <div class="form-group">
                                        <select name="amount" id="amount" class="form-control">
                                            <option value="{{ $registrationPrice }}"> {{ $optionLabel }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="box-title-box mb-2">
                                <h1 class="box-title line-left family-mont">Payment Details</h1>
                                {{--<h4>Try Free for 30 Days!</h4>--}}
                                <p>Please enter your payment details.</p>
                            </div>
                            <!-- Display status message -->
                            <div id="paymentResponse" class="alert alert-danger hidden"></div>

                            <div id="card-element">
                                <!-- Stripe.js will create card input elements here -->
                            </div>
                            <?php /*
                            <div class="row"> 
                                <div class="col-md-12"> <div class="card-wrapper"></div></div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="radio fancy_radio">
                                            <label><input name="namehere" checked type="radio"><span>Credit Card</span></label>
                                        </div>
                                        <div class="pull-right">
                                            <img src="img/credit-cards.png" class="img-responsive center-block" style="width: 50%;float: right;margin-top: -45px;" />
                                        </div>
                                    </div>
                                    <div class="clearfix"></div><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input required type="tel" class="form-control form-control-lg card-number" name="number" id="card-number" maxlength="19" placeholder="Card Number" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control card-expiry form-control-lg date-formatter" name="expiry" id="date-format" placeholder="MM/YYYY" required autocomplete="off">
    					                    </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <input required type="text" class="form-control card-cvc form-control-lg" name="cvc" id="card-cvc" maxlength="16" placeholder="CVC" autocomplete="off">
                                            </div>
                                        </div>
                                    </div><!------  ROW--->
                                    <div class="form-group ">
                                        <input required type="text" class="form-control card-name form-control-lg" name="name" id="card-name" placeholder="Card Holder Name" autocomplete="off">
                                    </div>
    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-success btn-min-width" id="doPaymentButton">Continue</button>
                                    </div>
                                </div><!------  Col-md-6---->
                            </div><!------ ROW--->
                            */ ?>

                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-lg btn-success btn-min-width" id="doPaymentButton">Continue</button>
                                <input type="hidden" name="userType" value="lender" />
                            </div>

                            
                        </div>
                    </div>  <!----- Col-md-12--->
                    <div class="clearfix"></div>
                    
                </form>
            </div>
        </div>
        <div class="loader-overlay loader-outer form-loader hidden"><div class="loader">Please wait...<div class="loader-inner"></div></div></div>
    </section>
@endsection

@push('scripts-footer')
<script src="https://js.stripe.com/v3/"></script>
<script>
// Get API Key
let STRIPE_PUBLISHABLE_KEY = '<?= env('APP_ENV') != "production" ? env('STRIPE_TEST_PUBLISHABLE_KEY') : env('STRIPE_LIVE_PUBLISHABLE_KEY')?>';

// Create an instance of the Stripe object and set your publishable API key
const stripe = Stripe(STRIPE_PUBLISHABLE_KEY);

// Render Credit card input into the form
let elements = stripe.elements();
var style = {
    base: {
        lineHeight: "30px",
        fontSize: "16px",
        border: "1px solid #ff0000",
    }
};
let cardElement = elements.create('card', { hidePostalCode: true, style: style });
cardElement.mount('#card-element');

cardElement.on('change', function (event) {
    displayError(event);
});



// Select subscription form element
const lenderForm = document.querySelector("#lender-ragistration");

// Attach an event handler to subscription form
lenderForm.addEventListener("submit", handleSubscrSubmit);


async function handleSubscrSubmit(e) {
    e.preventDefault();
    setLoading(true);
    
    <?php if($userDetails->userSubscription->exists == true){ ?>
        // Create payment method and confirm payment intent.
        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: '<?=$userDetails->first_name.' '.$userDetails->last_name?>',
            },
        }).then((result) => {
            console.log("result ", result);
            if(result.error) {
                showMessage(result.error.message);
                setLoading(false);
            } else {
                // Successful subscription payment
                // Post the transaction info to the server-side script and redirect to the payment status page
                fetch("<?=route("register.updateCustomerPaymentMethod")?>", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: '<?=$userDetails->user_id?>', paymentMethod: result.paymentMethod}),
                })
                .then(response => response.json())
                .then(data => {
                    console.log("data ", data);
                    if (data.subscription) {
                        console..log(data.subscription);
                        // window.location = window.location.href;
                        // window.location = "<?=route("register.subscriptionRenewed", ["user_id" => $userDetails->user_id])?>";
                    } else {
                        showMessage(data.error);
                        setLoading(false);
                    }
                })
                .catch(console.error);
            }
        });
    <?php }else{ ?>
        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: '<?=$userDetails->first_name.' '.$userDetails->last_name?>',
            },
        }).then((result) => {
            console.log("result ", result);
            if(result.error) {
                showMessage(result.error.message);
                setLoading(false);
            } else {
                fetch("<?=route("register.createCustomerSubscription")?>", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ user_id: '<?=$userDetails->user_id?>', paymentMethod: result.paymentMethod }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log("data ", data);
                    if (data.subscription){
                        gtag('event', 'conversion', {
                            'send_to': 'AW-11277202705/2MVhCPHS_N8ZEJHqsYEq',
                            'value': data.subscription.paid_amount,
                            'currency': 'USD',
                            'transaction_id': data.subscriptionInvoice.charge
                        });

                        gtag('event', 'purchase', {
                            transaction_id: data.subscriptionInvoice.charge,  // Replace with dynamic transaction ID
                            value: data.subscription.paid_amount,  // Replace with dynamic total value
                            currency: 'USD',  // Replace with your currency code
                        });


                        // paymentProcess(data.subscriptionId, data.clientSecret, data.customerId);
                        window.location = "<?=route("register.paymentStatus", ["user_id" => $userDetails->user_id])?>";
                    } else {
                        showMessage(data.error);
                        setLoading(false);
                    }
                })
                .catch(console.error);
            }
        }).catch(console.error);
        // Post the subscription info to the server-side script        
        /*fetch("<?=route("register.createCustomerSubscription")?>", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ user_id: '<?=$userDetails->user_id?>' }),
        })
        .then(response => response.json())
        .then(data => {
            console.log("data ", data);
            if (data.subscriptionId){
                if(data.clientSecret) {
                    paymentProcess(data.subscriptionId, data.clientSecret, data.customerId);
                }else{
                    
                }
            } else {
                setLoading(false);
                showMessage(data.error);
            }
        })
        .catch(console.error);*/
    <?php } ?>
}

function paymentProcess(subscriptionId, clientSecret, customerId){
    let customer_name = document.getElementById("first_name").value +" "+document.getElementById("last_name").value;
    
    // Create payment method and confirm payment intent.
    stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: cardElement,
            billing_details: {
                name: customer_name,
            },
        }
    }).then((result) => {
        if(result.error) {
            showMessage(result.error.message);
            setLoading(false);
        } else {
            // Successful subscription payment
            // Post the transaction info to the server-side script and redirect to the payment status page
            fetch("<?=route("register.createStripePayment")?>", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ subscription_id: subscriptionId, customer_id: customerId,payment_intent: result.paymentIntent, user_id: '<?=$userDetails->user_id?>'}),
            })
            .then(response => response.json())
            .then(data => {
                // console.log("data ", data);
                if (data.subscription) {
                    window.location = "<?=route("register.paymentStatus", ["user_id" => $userDetails->user_id])?>";
                } else {
                    showMessage(data.error);
                    setLoading(false);
                }
            })
            .catch(console.error);
        }
    });
}



function displayError(event) {
    if (event.error) {
        showMessage(event.error.message);
    }
}

// Display message
function showMessage(messageText) {
    const messageContainer = document.querySelector("#paymentResponse");
    
    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;
    
    setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageText.textContent = "";
    }, 5000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#doPaymentButton").disabled = true;
        $(".form-loader").removeClass("hidden");
    } else {
        // Enable the button and hide spinner
        document.querySelector("#doPaymentButton").disabled = false;
        $(".form-loader").addClass("hidden");
    }
}
</script>
@endpush