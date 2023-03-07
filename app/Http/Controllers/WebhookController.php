<?php

namespace App\Http\Controllers;

use App\Events\Subscriptions\CancelledSubscription;
use App\Events\Subscriptions\NewSubscription;
use Braintree\WebhookNotification;
use Illuminate\Http\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
	/**
	 * Handle the subscription_went_active webhook
	 *
	 * @param $webhook
	 * @return Response
	 */
//	public function handleSubscriptionWentActive($webhook)
//	{
//
//		$subscription = $this->getSubscriptionById($webhook->subscription->id);
//		event(new NewSubscription($subscription));
//
//		return new Response('Webhook Handled', 200);
//	}

	/**
	 * Handle the subscription_charged_successfully webhook
	 *
	 * @param WebhookNotification $webhook
	 * @return Response
	 */
//	public function handleSubscriptionChargedSuccessfully(WebhookNotification $webhook)
//	{
//		\Log::info('handling subscription charged successfully');
//		$subscription = $this->getSubscriptionById($webhook->subscription->id);
//		\Log::info($subscription);
//		return new Response('Webhook Handled', 200);
//	}

//	public function handleSubscriptionCanceled($webhook)
//	{
//		$subscription = $this->getSubscriptionById($webhook->subscription->id);
//		event(new CancelledSubscription($subscription));
//
//		return parent::handleSubscriptionCanceled($webhook);
//	}
}
