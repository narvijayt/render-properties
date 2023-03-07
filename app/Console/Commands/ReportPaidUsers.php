<?php

namespace App\Console\Commands;

use App\Jobs\SendReport;
use App\User;
use Illuminate\Console\Command;

class ReportPaidUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:paid-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a report of all paid users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$users = User::query()
			->whereNotNull('braintree_id')
			->get()
			->filter(function(User $user) {
				return $user->subscribed('main');
			});

		$file = builder_user_report_csv($users);

		dispatch(New SendReport($file, 'paid-users-report'));

		$this->info('Report Generated and sent to: '.config('mail.send_to_addresses.reports'));
    }
}
