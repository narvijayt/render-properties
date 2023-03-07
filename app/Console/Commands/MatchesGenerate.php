<?php

namespace App\Console\Commands;

use App\Jobs\SendMatchesEmail;
use App\Mail\Matching\MatchSuggestions;
use App\Services\Matching\Suggest;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;

class MatchesGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:generate {email?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate matches for each user and send them via email. Optionally pass an email address to generate matches for a single user';

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

        $query = User::whereIn('user_type', ['realtor', 'broker'])
			->where('verified', true);

        if ($this->hasArgument('email') && !empty($this->argument('email'))) {
        	$query->whereIn('email', $this->argument('email'));
		}

        $users = $query->get();
        // create variable to pass by reference that will contain
		// the progress bar
        $bar = null;

		$users->filter(function(User $user) {
			return $user->settings->email_receive_match_suggestions === true;
		})->tap(function($users) use (&$bar) {
			$bar =	$this->output->createProgressBar($users->count());
		})->each(function(User $user) use (&$bar) {
			$suggestService = app()->make(Suggest::class);
			$matches = $suggestService->byUser($user);

			$job = new SendMatchesEmail($user, $matches);
			dispatch($job);

			$bar->advance();
		});

		$bar->finish();
    }
}
