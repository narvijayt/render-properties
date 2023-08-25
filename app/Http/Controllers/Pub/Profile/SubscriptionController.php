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
use App\Mail\SubscriptionCancelled;
use App\Mail\SubscriptionPaymentFailed;
use App\Mail\VendorPaymentInvoice;

class SubscriptionController extends Controller
{
    //

    public function index(){
        $userDetails = User::with("userSubscription")->find(Auth::user()->user_id);
        $subscription = [];
        if($userDetails->userSubscription->exists == true){
            $subscription = (new Stripe())->getSubscription($userDetails->userSubscription->stripe_subscription_id);
            if(!is_object($subscription->latest_invoice)){
                $subscriptionInvoice = (new Stripe())->getInvoice($subscription->latest_invoice);
            }else{
                $subscriptionInvoice = $subscription->latest_invoice;
            }
        }
        return view('pub.profile.subscription.index', compact('userDetails', 'subscription'));
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

        // Payment Invoice Email
        // $email = new PaymentConfirmation($user);
        // Mail::to("amit@culture-red.com")->send($email);
        
        $email = new VendorPaymentInvoice($user);
        Mail::to("amit@culture-red.com")->send($email);


        // Subscription Cancelled Mail
        // $email = new SubscriptionCancelled($user);
        // Mail::to("amit@culture-red.com")->send($email);
        
        // Subscription Payment Failed  Mail
        // $email = new SubscriptionPaymentFailed($user);
        // Mail::to("amit@culture-red.com")->send($email);
        die("Completed!");
    }
}
