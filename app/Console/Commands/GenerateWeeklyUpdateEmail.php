<?php

namespace App\Console\Commands;

use App\Jobs\WeeklyUpdateEmail;
use App\Match;
use App\User;
use Illuminate\Console\Command;

class GenerateWeeklyUpdateEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:weekly-update {email?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a weekly update email to users updating them on missing conversations and pending match requests';

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
    	$query  = User::whereVerified(true);

		if ($this->hasArgument('email') && !empty($this->argument('email'))) {
			$query->whereIn('email', $this->argument('email'));
		}

		$users = $query->get();

    	$progressBar = null;
    	$users->filter(function(User $user) {
    		return $user->settings->email_receive_weekly_update_email;
		})->tap(function($users) use (&$progressBar) {
			$progressBar = $this->output->createProgressBar($users->count());
		})->each(function(User $user) use (&$progressBar) {
			$matches = Match::query()->pending($user)->get();
			$unreadCount = $user->unread_message_count();

			// Fetch all users within 100 miles
			$userType = $user->user_type === 'realtor' ? 'broker' : 'realtor';
			$areaUsers = User::where('user_type', $userType)
				->where('user_id', '!=', $user->user_id)
				->selectDistance($user->latitude, $user->longitude)
				->distance($user->latitude, $user->longitude, 100)
//				->where('created_at', '>=', new \DateTime($user->last_activity))
				->get()
				->filter(function(User $user) {
					return $user->isAbleToReceiveMatch();
				});

			$newAreaUsers = $areaUsers->filter(function(User $u) use ($user)  {
				return $u->created_at >= new \DateTime($user->last_activity ?? $user->created_at);
			});

			if ($matches->count() > 0 || $unreadCount > 0 || $areaUsers->count() > 0) {
				dispatch(new WeeklyUpdateEmail($user, $matches->count(), $unreadCount, $areaUsers->count(), $newAreaUsers->count()));
			}

			$progressBar->advance();
		});

    	$progressBar->finish();
    }
}
