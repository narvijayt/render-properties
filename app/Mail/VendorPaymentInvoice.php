<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\VendorPackages;
use App\VendorDetails;
use App\User;
use App\Services\Stripe;

class VendorPaymentInvoice extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $subscription = $subscriptionInvoice = $package = [];
        if($user->userSubscription->exists == true){
            $subscription = (new Stripe())->getSubscription($user->userSubscription->stripe_subscription_id);

            if(!is_object($subscription->latest_invoice)){
                $subscriptionInvoice = (new Stripe())->getInvoice($subscription->latest_invoice);
            }else{
                $subscriptionInvoice = $subscription->latest_invoice;
            }
            $membershipPrice = ($user->user_type == "vendor") ? $user->userSubscription->paid_amount :  ($subscription->plan->amount/100);
        }
        $vendorDetails = VendorDetails::where('user_id','=',$user->user_id)->first();
        if($user->packageId){
            $package = VendorPackages::find($user->packageId);
        }
        // return $this->view('view.name');
        return $this->from(config('mail.from.address'), 'Render')
            ->subject("Render: Payment Invoice")
            ->markdown('email.subscription.vender-payment-invoice', compact('user', 'subscription', 'subscriptionInvoice', 'membershipPrice', 'vendorDetails', 'package'));
    }
}
