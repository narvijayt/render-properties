<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

class MatchSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$userCount = User::count();

		$matchMax = floor($userCount * .35);
		$matchMin = floor($userCount * .15);

		$matchCount = mt_rand($matchMin, $matchMax);

		$this->command->getOutput()->progressStart($matchCount);

		for ($i = 0; $i < $matchCount; $i++) {
			$brokers = User::brokers()
				->get()
				->filter(function(User $user) {
					return $user->isAbleToRequestMatch();
				});

			$realtors = User::realtors()
				->get()
				->filter(function(User $user) {
					return $user->isAbleToReceiveMatch();
				});

			if ($brokers->count() === 0 || $realtors->count() === 0) {
				$i = $matchCount + 1;
				break;
			}

			$broker = $brokers->random();
			$realtor = $realtors->random();

			/** @var \App\Match $match */
			$match = factory(\App\Match::class)->states('accepted-1', 'accepted-2', 'accepted-both', 'deleted')->create([
				'user_id1' => $broker->user_id,
				'user_type1' => $broker->user_type,
				'user_id2' => $realtor->user_id,
				'user_type2' => $realtor->user_type,
			]);

			if ($match->isDeleted() && mt_rand(0, 1) === 1) {
				$match->requestRenewal($realtor);
			}

			$this->command->getOutput()->progressAdvance();
		}
		$this->command->getOutput()->progressFinish();
	}
}
