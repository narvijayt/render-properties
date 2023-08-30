<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserSubscriptions;
use App\User;
use App\Category;
use DB;

class SubscriptionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:validate-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Keep validating the Subscription Payment and End Date Status';

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
        //
        $cancelledSubscripitons = UserSubscriptions::where(DB::raw('DATE(plan_period_end)'), '=', date("Y-m-d", strtotime("-1 day")))->whereNotNull('cancelled_at')->get();
        // dd($cancelledSubscripitons);
        if(!is_null($cancelledSubscripitons)){
            foreach($cancelledSubscripitons as $subscription){
                $user = User::find($subscription->user_id);
                if($user->payment_status == 1){
                    $user->payment_status = 0;
                    $user->save();
                }

                if($user->user_type == "vendor"){
                    Category::where('user_id', $user->user_id)->update(['braintree_id' => null]);
                }
            }
        }
    }
}
