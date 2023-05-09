@extends('pub.profile.layouts.profile')
@php $userDetails = Auth::user(); @endphp
@section('title', 'Manage Subscription')

@section('page_content')

<div class="panel panel-default">
    <div class="panel-heading">Your Subscription plan</div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item clearfix">
                <div class="pull-left">
                    @if(!empty($userSubscription))
                        <h4>Monthly Lender Membership For 19.80 USD</h4>
                        <ul>
                            <li><strong>Price:</strong> <span class=""> ${{ number_format($userSubscription['paid_amount'], 2, '.', '') }}</span></li>
                            <li><strong>Registred Date:</strong> <span class="">{{ date("d-m-Y", strtotime($userSubscription['created_at'])) }}</span></li>
                            <li><strong>Start Date:</strong> <span class="">{{ date("d-m-Y", strtotime($userSubscription['plan_period_start'])) }}</span></li>
                            <li><strong>End Date:</strong> <span class="">{{ date("d-m-Y", strtotime($userSubscription['plan_period_end'])) }}</span></li>
                        </ul>                        
                    @endif
                </div>
            </li>
        </ul>

        @if($userSubscription['status'] != 'active' && $userSubscription['attach_payment_status'] == 0)
            <div class="panel panel-default subscription-billing-section mt-2">
                <div class="panel-heading">Renew Subscription Plan Now!</div>
                <div class="panel-body">
                    <form id="subscription-renew" class="subscription-renew" method="post">
                        <div id="paymentResponse" class="alert alert-danger hidden"></div>

                        <div id="card-element">
                            <!-- Stripe.js will create card input elements here -->
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-lg btn-success btn-min-width" id="doPaymentButton">Renew Now!</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="loader-overlay loader-outer form-loader hidden"><div class="loader">Please wait...<div class="loader-inner"></div></div></div>
        @endif
    </div>
</div>

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
let cardElement = elements.create('card', { style: style });
cardElement.mount('#card-element');

cardElement.on('change', function (event) {
    displayError(event);
});



// Select subscription form element
const subscriptionForm = document.querySelector("#subscription-renew");

// Attach an event handler to subscription form
subscriptionForm.addEventListener("submit", handleSubscrSubmit);


async function handleSubscrSubmit(e) {
    e.preventDefault();
    setLoading(true);
    
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
            fetch("<?=route("pub.profile.subsctiption.attachPaymentMethod")?>", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ user_id: '<?=$userDetails->user_id?>', paymentMethod: result.paymentMethod}),
            })
            .then(response => response.json())
            .then(data => {
                console.log("data ", data);
                if (data.subscription) {
                    window.location = window.location.href;
                } else {
                    showMessage(data.error);
                    setLoading(false);
                }
            })
            .catch(console.error);
        }
    });
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
