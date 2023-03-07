<?php

namespace App\Console\Commands;

use App\User;
use App\Jobs\SendConfirmationReminderEmail;
use Illuminate\Console\Command;

class GenerateEmailConfirmationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:email-confirmation-reminder {email?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate email confirmation reminders to send to registered users who have never confirmed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

		ini_set('max_execution_time', 3600);
		ini_set('memory_limit', '512M');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$query  = User::whereVerified(false);

		if ($this->hasArgument('email') && !empty($this->argument('email'))) {
			$query->whereIn('email', $this->argument('email'));
		}

		$users = $query->get();

		$progressBar = null;
		$users->filter(function(User $user) {
			return $user->settings->email_receive_email_confirmation_reminders;
		})->tap(function($users) use (&$progressBar) {
			$progressBar = $this->output->createProgressBar($users->count());
		})->each(function(User $user) use (&$progressBar) {
			$userType = $user->user_type === 'realtor' ? 'broker' : 'realtor';
			$areaUsers = User::where('user_type', $userType)
				->where('user_id', '!=', $user->user_id)
				->selectDistance($user->latitude, $user->longitude)
				->distance($user->latitude, $user->longitude, 100)
				->get()
				->filter(function(User $user) {
					return $user->isAbleToReceiveMatch();
				});

			$newAreaUsers = $areaUsers->filter(function(User $u) use ($user)  {
				return $u->created_at >= new \DateTime($user->last_activity ?? $user->created_at);
			});

			dispatch(new SendConfirmationReminderEmail($user, $areaUsers->count(), $newAreaUsers->count()));

			$progressBar->advance();
		});

		$progressBar->finish();
    }
}
