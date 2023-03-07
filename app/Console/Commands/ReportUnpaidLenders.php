<?php

namespace App\Console\Commands;

use App\Jobs\SendReport;
use App\User;
use Illuminate\Console\Command;

class ReportUnpaidLenders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:unpaid-lenders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a report of all unpaid lenders';

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
			->where('user_type', 'broker')
			->whereNull('braintree_id')
			->get()
			->filter(function(User $user) {
				return !$user->isPayingCustomer();
			});

		$file = builder_user_report_csv($users);

		dispatch(New SendReport($file, 'unpaid-lenders-report'));

		$this->info('Report Generated and sent to: '.config('mail.send_to_addresses.reports'));
    }
}
