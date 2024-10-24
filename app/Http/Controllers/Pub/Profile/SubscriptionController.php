<?php

namespace App\Http\Controllers\Pub\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Category;
use App\UserSubscriptions;
use Response;
use App\Services\Stripe;
use Mail;
use App\Mail\PaymentConfirmation;
use App\Mail\SubscriptionCancelled;
use App\Mail\SubscriptionPaymentFailed;
use App\Mail\VendorPaymentInvoice;
use App\VendorDetails;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    //

    public function index(){
        $data['userDetails'] = User::with("userSubscription")->with('vendorPackage')->find(Auth::user()->user_id);
        $subscription = [];
        if($data['userDetails']->userSubscription->exists == true){
            $data['subscription'] = (new Stripe())->getSubscription($data['userDetails']->userSubscription->stripe_subscription_id);
            if(!is_object($data['subscription']->latest_invoice)){
                $data['subscriptionInvoice'] = (new Stripe())->getInvoice($data['subscription']->latest_invoice);
            }else{
                $data['subscriptionInvoice'] = $data['subscription']->latest_invoice;
            }
        }
        if($data['userDetails']->user_type == "vendor"){
            $data['vendorDetails'] = VendorDetails::where('user_id','=',$data['userDetails']->user_id)->first();
        }
        return view('pub.profile.subscription.index', $data);
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
    
    public function cancel(Request $request){
        parse_str($request->input('formData'), $formdata);
        $rules = array(
            'reason'    => 'required', // make sure the reason is available
        );

        $validator = Validator::make($formdata, $rules);

        if ($validator->fails()) {
            return Response::json(['success' => false, "message" => $validator->messages()], 400);
        }else{
            $userSubscription = UserSubscriptions::where("user_id",Auth::user()->user_id)->first();
            $cancelArray = [
                'cancellation_details'  =>   [
                    'comment'   =>  $formdata['comment'],
                    'feedback'   =>  $formdata['reason']
                ]
            ];
            $subscriptionData = (new Stripe())->cancelSubscription($userSubscription->stripe_subscription_id, $cancelArray);
            if($subscriptionData->id){
                $userSubscription->cancelled_at = date("Y-m-d H:i:s");
                $userSubscription->save();

                if($userSubscription->status == "trialing"){
                    $user = User::find($userSubscription->user_id);
                    if($user->payment_status == 1){
                        $user->payment_status = 0;
                        $user->save();
                    }

                    if($user->user_type == "vendor"){
                        Category::where('user_id', $user->user_id)->update(['braintree_id' => null]);
                    }
                }
                
                return Response::json(['success' => true, "message" => "Cancelled successfully"], 200);
            }else{
                return Response::json(['success' => false, "message" => $subscriptionData->message], 400);
            }
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
