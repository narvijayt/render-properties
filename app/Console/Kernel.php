<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
		\App\Console\Commands\CreateAdminUser::class,
		\App\Console\Commands\UserAddPrepaidTime::class,
		\App\Console\Commands\SyncPlans::class,
		\App\Console\Commands\MatchesClean::class,
		\App\Console\Commands\MatchesGenerate::class,
		\App\Console\Commands\ReportNewUsers::class,
		\App\Console\Commands\ReportAllUsers::class,
		\App\Console\Commands\ReportPaidUsers::class,
		\App\Console\Commands\ReportUnpaidLenders::class,
        \App\Console\Commands\TestEmail::class,
		\App\Console\Commands\GenerateThumbnails::class,
		\App\Console\Commands\GenerateUserUUID::class,
		\App\Console\Commands\GenerateWeeklyUpdateEmail::class,
		\App\Console\Commands\GenerateEmailConfirmationReminders::class,
		\App\Console\Commands\ResendEmailVerification::class,
		\App\Console\Commands\ActivateUser::class,
		\App\Console\Commands\UserPrepaidReset::class,
         \App\Console\Commands\AccountDisable::class,
        \App\Console\Commands\AccountEnable::class,
         \App\Console\Commands\ReportNewUsersListEveryFriday::class,
         \App\Console\Commands\LenderPatiniumMembership::class,
         \App\Console\Commands\VendorPlatiniumMembership::class,
         \App\Console\Commands\SubscriptionStatus::class,
         
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//    	$schedule->command('matches:clean')->dailyAt('00:00');
         
        $schedule->command('registeredtillfriday:users_list')
          ->fridays()
          ->at('9:00')
        ->timezone('America/New_York');
        
       $schedule->command('reports:new-users')
			->daily()
			->at('9:00')
			->timezone('America/New_York');
			
		$schedule->command('reports:all-users')
			->daily()
			->at('9:00')
			->timezone('America/New_York');
		
		$schedule->command('subscription:validate-payment')
			->daily()
			->at('6:00')
			->timezone('America/New_York');
			
		/*	$schedule->command('lender-platinium:cron')
			->tuesdays()
			->at('10:00')
			->timezone('America/New_York');
			
			$schedule->command('vendor-platinium:cron')
			->tuesdays()
			->at('10:00')
			->timezone('America/New_York');*/
			
			
			
			
			//$schedule->command('lender-platinium:cron')->everyMinute();
		    //$schedule->command('vendor-platinium:cron')->everyMinute();
			
			  /*$schedule->command('registeredtillfriday:users_list')->everyMinute();
			  $schedule->command('reports:new-users')->everyMinute();*/
			
		

//		$schedule->command('reports:paid-users')
//			->daily()
//			->at('06:00')
//			->timezone('America/New_York');

//		$schedule->command('reports:unpaid-lenders')
//			->()
//			->at('06:00')
//			->timezone('America/New_York');
       	/*$schedule->command('reports:all-users')
			->mondays()
			->at('06:00')
			->timezone('America/New_York');

    	$schedule->command('email:weekly-update')
			->mondays()
			->at('8:30')
			->timezone('America/New_York');

    	$schedule->command('matches:generate')
			->weekly()
			->wednesdays()
			->at('10:00')
			->timezone('America/New_York');

		$schedule->command('admin:reset-prepaid')
			->daily()
			->at('01:00')
			->timezone('America/New_York');*/
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
