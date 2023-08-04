<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;
use App\Services\Stripe;
use App\UserSubscriptions;
use Response;
use Illuminate\Support\Facades\Log;
use App\Mail\SubscriptionPaymentFailed;
use App\Mail\SubscriptionCancelled;
use App\Mail\PaymentConfirmation;


class StripeWebhook extends Controller
{
    //

    public function manageSubscriptionStatus(Request $request){

        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $payload = @file_get_contents('php://input');
        $event = (new Stripe())->getWebhookEvent($payload, $sig_header);
        if(isset($event->status) && $event->status == 400){
            echo json_encode($event);
            http_response_code(400);
            exit();
        }
        // Handle the event
        switch ($event->type) {
            case 'customer.subscription.updated':
                $subscriptionSchedule = $event->data->object;
                if($subscriptionSchedule->object == "subscription"){
                    $subscriptionArray = [];
                    $subscriptionInvoice = (new Stripe())->getInvoice($subscriptionSchedule->latest_invoice);
                    if($subscriptionInvoice->status != "draft"){
                        $userSubscription = UserSubscriptions::where('stripe_subscription_id',$subscriptionSchedule->id)->first();
                        if($userSubscription){
                            $subscriptionArray['attach_payment_status'] = 0;

                            if($subscriptionSchedule->status == "active"){
                                $subscriptionArray['plan_period_start'] = date("Y-m-d H:i:s", $subscriptionSchedule->current_period_start); 
                                $subscriptionArray['plan_period_end'] = date("Y-m-d H:i:s", $subscriptionSchedule->current_period_end);
                                $subscriptionArray['plan_interval_count'] = $userSubscription->plan_interval_count +1;
                                $subscriptionArray['paid_amount'] = ($subscriptionInvoice->amount_paid/100);
                            }else if($subscriptionSchedule->status == "past_due"){
                                // Send notification of failed payment
                                $user = User::find($userSubscription->user_id);
                                $email = new SubscriptionPaymentFailed($user);
                                Mail::to($user->email)->send($email);
                            }else if($subscriptionSchedule->status == "unpaid"){
                                User::Where('user_id', $userSubscription->user_id)->update(['payment_status' => 0]);
                                $user = User::find($userSubscription->user_id);
                                $email = new SubscriptionCancelled($user);
                                Mail::to($user->email)->send($email);
                            }

                            $subscriptionArray['status'] = $subscriptionSchedule->status;
                            UserSubscriptions::Where('user_id', $userSubscription->user_id)->update($subscriptionArray);

                            if( ($userSubscription->plan_period_end != date("Y-m-d H:i:s", $subscriptionSchedule->current_period_end) ) && $subscriptionSchedule->status == "active"){
                                User::Where('user_id', $userSubscription->user_id)->update(['payment_status' => 1]);
                                if($subscriptionInvoice->amount_paid > 0){
                                    $user = User::with("userSubscription")->find($userSubscription->user_id);
                                    $email = new PaymentConfirmation($user);
                                    Mail::to($user->email)->send($email);
                                }
                            }

                            echo json_encode($userSubscription);
                        }else{
                            echo 'Received unknown subscription request ' . $subscriptionSchedule->id;
                        }
                    }else{
                        echo 'Received requiest under draft Invoice status. Subscription ID: ' . $subscriptionSchedule->id.' and Invoice ID: '.$subscriptionInvoice->id;
                    }
                }
            break;

            case 'invoice.paid':
                $invoice = $event->data->object;
                if($invoice->object == "invoice" && (isset($invoice->subscription) && !empty($invoice->subscription)) ){
                    $userSubscription = UserSubscriptions::where('stripe_subscription_id',$invoice->subscription)->first();
                    if($userSubscription->exists == true){
                        $subscriptionArray['attach_payment_status'] = 0;
                        $subscription = (new Stripe())->getSubscription($invoice->subscription);

                        $subscriptionArray['plan_period_start'] = date("Y-m-d H:i:s", $subscription->current_period_start); 
                        $subscriptionArray['plan_period_end'] = date("Y-m-d H:i:s", $subscription->current_period_end);
                        $subscriptionArray['plan_interval_count'] = $userSubscription->plan_interval_count +1;
                        $subscriptionArray['paid_amount'] = ($invoice->amount_paid/100);

                        $subscriptionArray['status'] = $subscription->status;
                        UserSubscriptions::Where('user_id', $userSubscription->user_id)->update($subscriptionArray);

                        if( ($userSubscription->plan_period_end != date("Y-m-d H:i:s", $subscription->current_period_end) ) && $subscription->status == "active"){
                            User::Where('user_id', $userSubscription->user_id)->update(['payment_status' => 1]);
                            if($invoice->amount_paid > 0){
                                $user = User::with("userSubscription")->find($userSubscription->user_id);
                                $email = new PaymentConfirmation($user);
                                Mail::to($user->email)->send($email);
                            }
                        }

                        echo json_encode($userSubscription);
                    }
                }
            break;

            case 'invoice.payment_failed':
                $invoice = $event->data->object;
                if($invoice->object == "invoice" && (isset($invoice->subscription) && !empty($invoice->subscription)) ){
                    $userSubscription = UserSubscriptions::where('stripe_subscription_id',$invoice->subscription)->first();
                    if($userSubscription->exists == true){
                        $subscription = (new Stripe())->getSubscription($invoice->subscription);
                        if($subscription->status == "past_due"){
                            // Send notification of failed payment
                            $user = User::find($userSubscription->user_id);
                            $email = new SubscriptionPaymentFailed($user);
                            Mail::to($user->email)->send($email);
                        }else if($subscription->status == "unpaid"){
                            User::Where('user_id', $userSubscription->user_id)->update(['payment_status' => 0]);
                            $user = User::find($userSubscription->user_id);
                            $email = new SubscriptionCancelled($user);
                            Mail::to($user->email)->send($email);
                        }

                        $subscriptionArray['status'] = $subscription->status;
                        UserSubscriptions::Where('user_id', $userSubscription->user_id)->update($subscriptionArray);

                        echo json_encode($userSubscription);
                    }
                }
                
            break;
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
            break;
        }

        http_response_code(200);
        exit();
    }
}
