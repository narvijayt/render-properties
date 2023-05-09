<?php

namespace App\Http\Controllers\Pub\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\UserSubscriptions;
use Response;
use App\Services\Stripe;

class SubscriptionController extends Controller
{
    //

    public function index(){
        $userSubscription = UserSubscriptions::where("user_id",Auth::user()->user_id)->first();
        return view('pub.profile.subscription.index', compact('userSubscription'));
    }

    public function attachPaymentMethod(Request $request){
        $customer_id = Auth::user()->stripe_customer_id;
        $paymentMethod = $request->input('paymentMethod');
        if(!empty($customer_id)){
            $customerPaymentMethod = (new Stripe())->attachPaymentMethodToCustomer($customer_id, $paymentMethod['id']);
            \Log::error("customerPaymentMethod ".json_encode($customerPaymentMethod));
            if($customerPaymentMethod->id){
                $userSubscription = UserSubscriptions::where("user_id",Auth::user()->user_id)->first();

                $subscriptionData = (new Stripe())->updateSubscription($userSubscription->stripe_subscription_id, ['default_payment_method' => $paymentMethod['id'], 'billing_cycle_anchor' => 'now']);
                if($subscriptionData->id){
                    $userSubscription->attach_payment_status = 1;
                    $userSubscription->save();
                }

                return Response::json(['customerPaymentMethod' => $customerPaymentMethod, 'subscription' => $subscriptionData], 200);
            }

            return Response::json(['customerPaymentMethod' => $customerPaymentMethod], 200);
        }
    }
}
