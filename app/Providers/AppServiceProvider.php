<?php

namespace App\Providers;

use App\Broker;
use App\BrokerSale;
use App\Conversation;
use App\Enums\UserRolesEnum;
use App\Http\Kernel;
use App\Message;
use App\MonthlySale;
use App\Realtor;
use App\RealtorSale;
use App\User;
use App\UserAvatar;
use App\UserBlock;
use App\UserDetail;
use App\VendorCategories;
use Illuminate\Support\Facades\View;
use App\UserProfileViolation;
use App\UserProvider;
use App\UserSetting;
use Bouncer;
use Hash;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use URL;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel, UrlGenerator $url)
    {
        $selected = array();
        $cat = VendorCategories::orderBy('name')->get();
        if(count($cat)>0)
        {
            $collection = collect($cat);
            foreach ($collection as $key => $value) 
            {
                if ($value->id == '19') 
                {
                    $selected[] = $value;
                    $collection->forget($key);
                }
            }
            if(!empty($selected))
            {
                $allcat = $collection->push($selected[0]);
            }else{
                $allcat = $cat;
            }
        }else{
            $allcat = array(); 
        }
        View::share('allcat', $allcat);
		Validator::extend('authPassword', function($attribute, $value, $parameters, $validators) {
			return Hash::check($value, auth()->user()->getAuthPassword());
		});

		Validator::extend('exclusiveElements', function($attribute, $value, $parameters, $validators) {
			$query = explode(',', $value);

			$invalidElements = array_diff($query, $parameters);
			return (
				count($invalidElements) === 0 ? true : false
			);
		});

		Validator::extend('zip', function($attribute, $value, $parameters, $validators) {
			return preg_match('/^[0-9]{5}(\-[0-9]{4})?$/', $value);
		});

		Validator::extend('ltfield', function ($attribute, $value, $parameters, \Illuminate\Validation\Validator $validator) {
			$data = $validator->getData();

			return $value < $data[$parameters[0]];
		});

		Validator::extend('gtfield', function ($attribute, $value, $parameters, \Illuminate\Validation\Validator $validator) {
			$data = $validator->getData();

			return $value > $data[$parameters[0]];
		});
		
		
		 Validator::extend(
          'recaptcha',
          'App\\Validators\\ReCaptcha@validate'
             );

		if (config('app.env', 'production') !== 'local') {
			// Force https on all generated urls
			$url->forceScheme('https');
		} else {
			$url->forceScheme('http');
		}

		\Braintree_Configuration::environment(config('services.braintree.environment'));
		\Braintree_Configuration::merchantId(config('services.braintree.merchant_id'));
		\Braintree_Configuration::publicKey(config('services.braintree.public_key'));
		\Braintree_Configuration::privateKey(config('services.braintree.private_key'));

		// Declare bouncer ownership criteria
		$this->setBouncerOwnershipBindings();

		// This is called during database seeding automatically, however
		// in production the artisan command will need to be run.
		//
		// php artisan bouncer:seed
		//
		Bouncer::seeder(function() {
			// Roles
			$this->createRoles();

			// Create abilities
			$this->createOwnerAbilities();
			$this->createAdminAbilities();
			$this->createUserAbilities();
			$this->createRealtorAbilities();
			$this->createBrokerAbilities();
		});

		Bouncer::cache();
	}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		if ($this->app->environment() !== 'production') {
			$this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
			$this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
		}

		if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
			error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		}
    }

	/**
	 * Declare ownership bindings for bouncer
	 *
	 * @return void
	 */
    public function setBouncerOwnershipBindings()
	{
		Bouncer::ownedVia(User::class, function(User $model, User $user) {
			return $model->user_id === $user->user_id;
		});

//		Bouncer::ownedVia(UserDetail::class, function(UserDetail $detail, User $user) {
//			return $detail->user_id === $user->user_id;
//		});

//		Bouncer::ownedVia(Realtor::class, function(Realtor $realtor, User $user) {
//			return $realtor->user_id === $user->user_id;
//		});

		Bouncer::ownedVia(MonthlySale::class, function(MonthlySale $sale, User $user) {
			return $sale->user->user_id === $user->user_id;
		});

//        Bouncer::ownedVia(RealtorSale::class, function(RealtorSale $sale, User $user) {
//            return $sale->realtor->user->user_id === $user->user_id;
//        });

//		Bouncer::ownedVia(Broker::class, function(Broker $broker, User $user) {
//			dd($broker,$user);
//			return $broker->user_id === $user->user_id;
//		});

		Bouncer::ownedVia(UserAvatar::class, function(UserAvatar $avatar, User $user) {
			return $avatar->user_id === $user->user_id;
		});

		Bouncer::ownedVia(UserBlock::class, function(UserBlock $block, User $user) {
			return $block->user_id === $user->user_id;
		});

		Bouncer::ownedVia(UserProvider::class, function(UserProvider $provider, User $user) {
			return $provider->user_id === $user->user_id;
		});

		Bouncer::ownedVia(Conversation::class, function(Conversation $conversion, User $user) {
			return $conversion->user_id === $user->user_id;
		});

		Bouncer::ownedVia(Message::class, function(Message $message, User $user) {
			return $message->user_id === $user->user_id;
		});
	}

	/**
	 * Create bouncer roles.
	 *
	 * @return void
	 */
	protected function createRoles()
	{
		Bouncer::allow(UserRolesEnum::OWNER)->to([]);
		Bouncer::allow(UserRolesEnum::ADMIN)->to([]);
		Bouncer::allow(UserRolesEnum::USER)->to([]);
		Bouncer::allow(UserRolesEnum::REALTOR)->to([]);
		Bouncer::allow(UserRolesEnum::BROKER)->to([]);
	}

	/**
	 * Create owner abilities
	 *
	 * @return void
	 */
	protected function createOwnerAbilities()
	{
		Bouncer::allow(UserRolesEnum::OWNER)->everything([
			'title' => 'Site Owner'
		]);
	}

    /**
     * Create Admin Abilities
     *
     * @return void
     */
	protected function createAdminAbilities()
    {
        Bouncer::allow(UserRolesEnum::ADMIN)->to('admin');
        Bouncer::allow(UserRolesEnum::ADMIN)->toManage(User::class);
    }
	/**
	 * Create user abilities
	 *
	 * @return void
	 */
	protected function createUserAbilities()
	{
		// User

        Bouncer::allow(UserRolesEnum::USER)->to('user:index', User::class, [
            'title' => 'List users',
        ]);
		Bouncer::allow(UserRolesEnum::USER)->to('user:view', User::class, [
			'only_owned' => true,
			'title' => 'View self',
		]);
		Bouncer::allow(UserRolesEnum::USER)->to('user:edit', User::class, [
			'only_owned' => true,
			'title' => 'Edit self',
		]);

		Bouncer::allow(UserRolesEnum::USER)->to('create-profile');


		Bouncer::allow(UserRolesEnum::USER)->to('conversation:index', Conversation::class, [
		    'title' => 'List Conversations',
        ]);
		Bouncer::allow(UserRolesEnum::USER)->to('conversation:view', Conversation::class, [
		    'title' => 'View Conversations',
        ]);
        Bouncer::allow(UserRolesEnum::USER)->to('conversation:create', Conversation::class, [
            'title' => 'Create Conversations',
        ]);
        Bouncer::allow(UserRolesEnum::USER)->to('conversation:edit', Conversation::class, [
            'only_owned' => true,
            'title' => 'Edit Conversations',
        ]);

        Bouncer::allow(UserRolesEnum::USER)->to('message:index', Message::class, [
            'title' => 'List Messages',
        ]);
        Bouncer::allow(UserRolesEnum::USER)->to('message:view', Message::class, [
            'title' => 'View Messages',
        ]);
        Bouncer::allow(UserRolesEnum::USER)->to('message:create', Message::class, [
            'title' => 'Create Messages',
        ]);
        Bouncer::allow(UserRolesEnum::USER)->to('message:edit', Message::class, [
            'only_owned' => true,
            'title' => 'Edit Message',
        ]);
        Bouncer::allow(UserRolesEnum::USER)->to('message:delete', Message::class, [
            'only_owned' => true,
            'title' => 'Delete Message',
        ]);

		// User Detail
        Bouncer::allow(UserRolesEnum::USER)->to('user-detail:index', UserDetail::class, [
            'title' => 'List details'
        ]);
		Bouncer::allow(UserRolesEnum::USER)->to('user-detail:view', UserDetail::class, [
//			'only_owned' => true,
			'title' => 'View own details'
		]);
		Bouncer::allow(UserRolesEnum::USER)->to('user-detail:create', UserDetail::class, [
			'title' => 'Create own details',
		]);
		Bouncer::allow(UserRolesEnum::USER)->to('user-detail:edit', UserDetail::class, [
			'only_owned' => true,
			'title' => 'Edit own details'
		]);

		// User Settings
		Bouncer::allow(UserRolesEnum::USER)->to('user-setting:view', UserSetting::class, [
			'only_owned' => true,
			'title' => 'View own settings'
		]);
		Bouncer::allow(UserRolesEnum::USER)->to('user-setting:create', UserSetting::class, [
			'title' => 'Create own settings'
		]);
		Bouncer::allow(UserRolesEnum::USER)->to('user-setting:edit', UserSetting::class, [
			'only_owned' => true,
			'title' => 'Edit own settings'
		]);

		Bouncer::allow(UserRolesEnum::USER)->to('monthly-sale:edit', MonthlySale::class, [
//			'only_owned' => true,
			'title' => 'Edit own sales',
		]);

		// User Profile Violation
		Bouncer::allow(UserRolesEnum::USER)->to('user-profile-violation:view', UserProfileViolation::class, [
			'title' => 'View profile violation reports',
		]);
		Bouncer::allow(UserRolesEnum::USER)->to('user-profile-violation:create', UserProfileViolation::class, [
			'title' => 'Create profile violation reports',
		]);

		// User Block
		Bouncer::allow(UserRolesEnum::USER)->to('user-block:create', UserBlock::class, [
			'title' => 'Create user blocks'
		]);
		Bouncer::allow(UserRolesEnum::USER)->toOwn(UserBlock::class, [
			'title' => 'Own user blocks'
		]);
		// User Avatar
		Bouncer::allow(UserRolesEnum::USER)->to('user-avatar:create', UserAvatar::class, [
			'title' => 'Create user avatar'
		]);
		Bouncer::allow(UserRolesEnum::USER)->toOwn(UserAvatar::class, [
			'title' => 'Own user avatar'
		]);

		// User Providers for social login
		Bouncer::allow(UserRolesEnum::USER)->to('user-provider:create', UserProvider::class, [
			'title' => 'Create user provider'
		]);
		Bouncer::allow(UserRolesEnum::USER)->toOwn(UserProvider::class, [
			'title' => 'Own user provider'
		]);

		Bouncer::allow(UserRolesEnum::USER)->to('broker:create', Broker::class, [
            'title' => 'Create a broker profile',
        ]);

        Bouncer::allow(UserRolesEnum::USER)->to('broker:create', Realtor::class, [
            'title' => 'Create a broker profile',
        ]);


	}

	/**
	 * Create realtor abilities
	 *
	 * @return void
	 */
	protected function createRealtorAbilities()
	{
		// Realtor Permissions
        Bouncer::allow(UserRolesEnum::REALTOR)->to('realtor-sale:index', RealtorSale::class, [
            'title' => 'List realtor sales'
        ]);
		Bouncer::allow(UserRolesEnum::REALTOR)->to('realtor-sale:create', RealtorSale::class, [
			'title' => 'Create realtor sales'
		]);
		Bouncer::allow(UserRolesEnum::REALTOR)->toOwn(RealtorSale::class, [
			'title' => 'Own realtor sales'
		]);
		Bouncer::allow(UserRolesEnum::REALTOR)->to('realtor:view', Realtor::class, [
			'only_owned' => true,
			'title' => 'View own realtor profile'
		]);
		Bouncer::allow(UserRolesEnum::REALTOR)->to('realtor:create', Realtor::class, [
			'title' => 'Create own realtor profile'
		]);
		Bouncer::allow(UserRolesEnum::REALTOR)->to('realtor:edit', Realtor::class, [
			'only_owned' => true,
			'title' => 'Edit own realtor profile'
		]);
	}

	/**
	 * Create Broker abilities
	 *
	 * @return void
	 */
	protected function createBrokerAbilities()
	{
		Bouncer::allow(UserRolesEnum::BROKER)->to('broker-sale:index', BrokerSale::class, [
			'title' => 'Create broker sales'
		]);
		Bouncer::allow(UserRolesEnum::BROKER)->to('broker-sale:create', BrokerSale::class, [
			'title' => 'Create broker sales'
		]);
		Bouncer::allow(UserRolesEnum::BROKER)->toOwn(BrokerSale::class, [
			'title' => 'Own broker sales'
		]);
		Bouncer::allow(UserRolesEnum::BROKER)->to('broker:view', Broker::class, [
			'only_owned' => true,
			'title' => 'View own broker profile'
		]);
		Bouncer::allow(UserRolesEnum::BROKER)->to('broker:create', Broker::class, [
			'title' => 'Create own broker profile'
		]);
		Bouncer::allow(UserRolesEnum::BROKER)->to('broker:edit', Broker::class, [
			'only_owned' => true,
			'title' => 'Edit own broker profile'
		]);
	}
}
