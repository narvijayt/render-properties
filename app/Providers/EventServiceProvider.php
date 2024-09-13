<?php

namespace App\Providers;

use API\Exceptions\Token\TokenExpiredException;
use API\Exceptions\Token\TokenInvalidException;
use API\Exceptions\Token\TokenInvalidUserException;
use API\Exceptions\Token\TokenMissingException;
use App\Listeners\Conversation\EmailSubscribers;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Registration\RealtorRegistered' => [
            'App\Listeners\Registration\GrantRealtorRole',
        ],
		'App\Events\Registration\BrokerRegistered' => [
			'App\Listeners\Registration\GrantBrokerRole',
		],
		'App\Events\Conversation\NewMessage' => [
			'App\Listeners\Conversation\EmailSubscribers',
		],
		'App\Events\Conversation\NewConversation' => [],

		// Matching
		'App\Events\Matching\NewMatch' => [
			'App\Listeners\Matching\NewMatchNotification'
		],
		'App\Events\Matching\NewMatchSuccess' => [
			'App\Listeners\Matching\NewMatchSuccessNotification'
		],
		'App\Events\Matching\Renew' => [
			'App\Listeners\Matching\RenewNotification'
		],
		'App\Events\Matching\RenewSuccess' => [
			'App\Listeners\Matching\RenewSuccessNotification'
		],

		// Subscriptions
		'App\Events\Subscriptions\NewSubscription' => [
			'App\Listeners\Subscriptions\NewSubscriptionNotification'
		],
		'App\Events\Subscriptions\CancelledSubscription' => [
			'App\Listeners\Subscriptions\CancelledSubscriptionNotification'
		],
		'App\Events\Subscriptions\ChangedSubscription' => [
			'App\Listeners\Subscriptions\ChangedSubscriptionNotification'
		],
		
		
		// Registration Alert
		'App\Events\NewMemberAlert' => [
			'App\Listeners\SendNewMemberAlert'
		],

		// Lead Notification
		'App\Events\LeadNotificationEvent' => [
			'App\Listeners\SendLeadNotification'
		],

		// Refinance Lead Notification
		'App\Events\RefinanceLeadNotificationEvent' => [
			'App\Listeners\SendRefinanceLeadNotification'
		],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

		Event::listen('tymon.jwt.absent', function() {
			throw new TokenMissingException("Token not provided", 400);
		});

		Event::listen('tymon.jwt.expired', function($user) {
			throw new TokenExpiredException("Token expired", 401);
		});

		Event::listen('tymon.jwt.invalid', function($user) {
			throw new TokenInvalidException("Token invalid", 401);
		});

		Event::listen('tymon.jwt.user_not_found', function() {
			throw new TokenInvalidUserException("User not found", 404);
		});
    }
}
