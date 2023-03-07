<?php

namespace App\Console\Commands;

use App\BraintreePlan;
use Braintree_Plan;
use Illuminate\Console\Command;

class SyncPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'braintree:sync-plans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync with online plans on Braintree';

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
        $plans = Braintree_Plan::all();
        foreach($plans as $plan) {
        	BraintreePlan::updateOrCreate(
        	    [
        	        'braintree_plan' => $plan->id,
                ],
        	    [
        		'name' => $plan->name,
				'slug' => str_slug($plan->name),
				'braintree_plan' => $plan->id,
				'cost' => $plan->price,
				'description' => $plan->description,
				'billing_frequency' => $plan->billingFrequency,
			]);
		}
    }
}
