<?php

namespace App\Http\Controllers\Pub\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\UserSubscriptions;
use Response;
use App\Services\Stripe;
use Mail;
use App\Mail\PaymentConfirmation;

class SubscriptionController extends Controller
{
    //

    public function index(){
        $userDetails = User::with("userSubscription")->find(Auth::user()->user_id);
        return view('pub.profile.subscription.index', compact('userDetails'));
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
                    UserSubscriptions::Where('user_id', $userSubscription->user_id)->update(['attach_payment_status' => 1]);
                }

                return Response::json(['customerPaymentMethod' => $customerPaymentMethod, 'subscription' => $subscriptionData], 200);
            }

            return Response::json(['customerPaymentMethod' => $customerPaymentMethod], 200);
        }
    }

    public function paymentInvoice(){
        $user = User::with('userSubscription')->find(Auth::user()->user_id);
        // dd($user->userSubscription->plan_period_start);
        $email = new PaymentConfirmation($user);
        Mail::to($user->email)->send($email);
    }
}
