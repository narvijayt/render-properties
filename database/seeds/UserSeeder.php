<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = mt_rand(100, 150);
		$this->command->getOutput()->progressStart($userCount);

        for ($i = 0; $i < $userCount; $i++) {
        	/** @var \App\User $user */
        	if (mt_rand(1, 3) === 2) {
				$user = factory(App\User::class)->states('type-broker')->create();
				$user->assign(['user', 'broker']);

				factory(\App\MatchPurchase::class)->states('complimentary')->create([
					'user_id' => $user->user_id,
					'quantity' => 2,
				]);

				factory(\App\MatchPurchase::class, mt_rand(0, 5))->states('purchased')->create([
					'user_id' => $user->user_id,
					'quantity' => mt_rand(1, 3),
				]);

				factory(\Laravel\Cashier\Subscription::class)->states('active', 'grace-period')->create([
					'user_id' => $user->user_id,
				]);

				$user->braintree_id = '123dsaf';
				$user->save();
			} else {
				$user = factory(App\User::class)->states('type-realtor')->create();
				$user->assign(['user', 'realtor']);

				factory(\App\MatchPurchase::class)->states('complimentary')->create([
					'user_id' => $user->user_id,
					'quantity' => 1,
				]);
			}

//			$user->sales()->saveMany($this->makeSales());
			$this->command->getOutput()->progressAdvance();

		}
		$this->command->getOutput()->progressFinish();
    }

	/**
	 * create sales for user
	 * @return array
	 */
    protected function makeSales()
	{
		// create sales
		$salesCount = mt_rand(4, 12);

		$sales = [];
		for ($i = 0; $i < $salesCount; $i++) {
			$time = \Carbon\Carbon::now()->startOfMonth()->subMonths($i);
			$sales[] = factory(App\MonthlySale::class)->make([
				'sales_year' => $time->format('Y'),
				'sales_month' => $time->format('m'),
				'sales_total' => mt_rand(1, 10),
				'sales_value' => mt_rand(100000, 100000000) * 1.0,
			]);
		}

		return $sales;
	}
}
