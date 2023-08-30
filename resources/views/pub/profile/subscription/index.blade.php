@extends('pub.profile.layouts.profile')

@section('title', 'Manage Subscription')

@section('page_content')

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">Your Subscription Details </div>
            @if(in_array($userDetails->userSubscription->status,['active', 'trialing']) && is_null($userDetails->userSubscription->cancelled_at))
                <div class="col-md-6">
                    <a data-toggle="modal" data-target="#subscription-cancel-modal" class="text text-danger pull-right text-link">Cancel Subscription</a>
                </div>
            @elseif(!is_null($userDetails->userSubscription->cancelled_at))
                <div class="col-md-6">
                    <span class="badge badge-danger pull-right">Cancelled</a>
                </div>
            @endif
        </div>
    </div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item clearfix">
                <div class="pull-left">
                    @if(!empty($userDetails->userSubscription))
                        @php
                            $membershipPrice = ($userDetails->user_type == "vendor") ? $userDetails->userSubscription->paid_amount :  ($subscription->plan->amount/100);
                        @endphp
                        <h4>Monthly {{ ucfirst($userDetails->user_type) }} Membership For {{ number_format( $membershipPrice,2, '.', '') }} {{ strtoupper($subscription->plan->currency) }}</h4>
                        <ul>
                            <li>
                                <strong>Price Paid:</strong> 
                                <span class=""> ${{ number_format($userDetails->userSubscription->paid_amount, 2, '.', '') }}</span>
                                @if($userDetails->userSubscription->paid_amount == 0)
                                    <span class="badge badge-warning">{{ ucfirst($userDetails->userSubscription->status)}}</span>
                                @endif
                            </li>
                            @if($userDetails->vendorPackage)
                                <li>
                                    <strong>Package Type:</strong> 
                                    <span class=""> {{ ucfirst($userDetails->vendorPackage->packageType )}}</span>
                                    @if(!is_null($vendorDetails) && $userDetails->vendorPackage->packageType != "usa")
                                    @php 
                                        $primaryLabel = 'package_selected_'.$userDetails->vendorPackage->packageType;
                                        $additionalLabel = 'additional_'.$userDetails->vendorPackage->packageType;
                                    @endphp
                                        <ul>
                                            <li>
                                                Primary {{ ucfirst($userDetails->vendorPackage->packageType)}}: <i>{{ $vendorDetails->$primaryLabel }}</i>
                                            </li>
                                            @if(!empty($vendorDetails->$additionalLabel))
                                                @php 
                                                    $additionalItems = json_decode($vendorDetails->$additionalLabel);
                                                @endphp
                                                <li>
                                                    Additional  {{ $package->packageType == "city" ? "Cities" : "States"}}:
                                                    @foreach($additionalItems as $item)
                                                        <br/><i> - {{$item}}</i>
                                                    @endforeach
                                                </li>
                                            @endif
                                        </ul>
                                    @endif
                                </li>
                            @endif

                            <li><strong>Registred Date:</strong> <span class="">{{ date("d-m-Y", strtotime($userDetails->userSubscription->created_at)) }}</span></li>
                            <li><strong>Start Date:</strong> <span class="">{{ date("d-m-Y", strtotime($userDetails->userSubscription->plan_period_start)) }}</span></li>
                            <li><strong>End Date:</strong> <span class="">{{ date("d-m-Y", strtotime($userDetails->userSubscription->plan_period_end)) }}</span></li>
                            @if(!is_null($userDetails->userSubscription->cancelled_at))
                            <li><strong>Cancellation Date:</strong> <span class="">{{ date("d-m-Y", strtotime($userDetails->userSubscription->cancelled_at)) }}</span></li>
                            @endif
                        </ul>                        
                    @endif
                </div>
            </li>
        </ul>
        {{--
            @php echo '<pre>'; print_r($userDetails->userSubscription); echo '</pre>'; @endphp
        --}}
        @if( !in_array($userDetails->userSubscription->status,['active', 'trialing']) && $userDetails->userSubscription->attach_payment_status == 0)
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
        @endif
        <div class="loader-overlay loader-outer form-loader hidden"><div class="loader">Please wait...<div class="loader-inner"></div></div></div>
    </div>
</div>

<div id="subscription-cancel-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color:#a94442;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align:center;background-color:#a94442;color:white;">Cancel Your Subscription</h4>
            </div>
            <form id="subscription-cancel-form" method="post">
                <div class="modal-body" style="background-color: #ece2cf;font-size: 17px;padding: 43px;">
                    <p>Why do you want to cancel your subscription?</p>
                    @php $reasons = subscription_cancelation_reasons(); @endphp
                    @foreach($reasons as $reasonValue=>$reasonLabel)
                        <div class="radio">
                            <label>
                                <input type="radio" class="cancel-reason" name="reason" value="{{$reasonValue}}">{{$reasonLabel}}
                            </label>
                        </div>
                    @endforeach
                    <div class="form-group other-reason hidden">
                        <label>Add Custom Reason</label>
                        <textarea class="form-control" name="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer p-1">
                    <div class="form-group mb-0">
                        <button type="button" class="btn btn-lg btn-danger btn-sm cancelSubscriptionBtn">Continue</button>
                        <button type="button" class="btn btn-lg btn-warning btn-sm" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts-footer')
<script src="https://js.stripe.com/v3/"></script>

<script>
    
$(document).ready(function(){
    $(document).on("click", ".cancelSubscriptionBtn", function(e){
        e.preventDefault();
        // setLoading(true);

        const formData = $("#subscription-cancel-form").serialize();
        fetch("<?=route("pub.profile.subsctiption.cancel")?>", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({formData}),
        })
        .then(response => response.json())
        .then(data => {
            // console.log("Result ", data);
            if (data.success == true) {
                window.location = window.location.href;
            } else {
                setLoading(false);
                alert(data.message);
            }
        })
        .catch(error => {
            // console.log("Opps!", error);
            // setLoading(false);
            alert(data.error);
        })
    });

    $(document).on("click", ".cancel-reason", function(){
        const reason = $(this).val();
        if(reason == "other"){
            $(".other-reason").removeClass("hidden");
        }else{
            $(".other-reason").addClass("hidden");
            $(".other-reason").find("textarea").val("");
        }
    })
});

if($("#card-element").length){
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
