<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		\App\User::class 			=> \App\Policies\UserPolicy::class,
		\App\UserAvatar::class 		=> \App\Policies\UserAvatarPolicy::class,
		\App\MonthlySale::class 	=> \App\Policies\MonthlySalePolicy::class,
		\App\Conversation::class 	=> \App\Policies\ConversationPolicy::class,
		\App\Message::class 		=> \App\Policies\MessagePolicy::class,
		\App\UserDetail::class 		=> \App\Policies\UserDetailPolicy::class,
		\App\Broker::class 			=> \App\Policies\BrokerPolicy::class,
		\App\Realtor::class 		=> \App\Policies\MonthlySalePolicy::class,
		\App\RealtorSale::class 	=> \App\Policies\RealtorSalePolicy::class,
		\App\BrokerSale::class 		=> \App\Policies\BrokerSalePolicy::class,
        \App\Review::class          => \App\Policies\ReviewPolicy::class,
		\App\UserSetting::class		=> \App\Policies\UserSettingPolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();
	}
}
