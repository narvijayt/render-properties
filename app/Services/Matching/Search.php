<?php

namespace App\Services\Matching;

use App\User;
use App\Enums\MatchActionType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class Search {
	public function byUser(User $user) {
		if ($user === null) {
			return collect([]);
		}
		$matches = $user->matches();

		$coll = collect([]);
		$coll_tmp = self::byStates($user->settings->match_by_states);
		$coll_tmp = $coll_tmp->diff($matches);
		if ($coll_tmp->count() > 0) {
			$coll_new = ($coll->count() == 0) ? $coll->union($coll_tmp) : $coll->intersect($coll_tmp);
			$coll = ($coll_new->count() > 0) ? $coll_new : $coll;
		}

		$coll_tmp = self::byExp($user->settings->match_by_exp_min, $user->settings->match_by_exp_max);
		$coll_tmp = $coll_tmp->diff($matches);
		if ($coll_tmp->count() > 0) {
			$coll_new = ($coll->count() == 0) ? $coll->union($coll_tmp) : $coll->intersect($coll_tmp);
			$coll = ($coll_new->count() > 0) ? $coll_new : $coll;
		}

		$coll_tmp = self::bySalesTotal($user->settings->match_by_sales_total_min, $user->settings->match_by_sales_total_max);
		$coll_tmp = $coll_tmp->diff($matches);
		if ($coll_tmp->count() > 0) {
			$coll_new = ($coll->count() == 0) ? $coll->union($coll_tmp) : $coll->intersect($coll_tmp);
			$coll = ($coll_new->count() > 0) ? $coll_new : $coll;
		}

		$coll_tmp = self::bySalesValue($user->settings->match_by_sales_value_min, $user->settings->match_by_sales_value_max);
		$coll_tmp = $coll_tmp->diff($matches);
		if ($coll_tmp->count() > 0) {
			$coll_new = ($coll->count() == 0) ? $coll->union($coll_tmp) : $coll->intersect($coll_tmp);
			$coll = ($coll_new->count() > 0) ? $coll_new : $coll;
		}

		return $coll;
	}

	public function byState(string ...$states) {
		if (empty($states)) {
			return collect([]);
		}
		return self::byStates($states);
	}

	public function byStates(?array $states) {
		if (empty($states)) {
			return collect([]);
		}
		$coll = collect([]);
		foreach ($states as $s) {
			$u = User::byState($s)->get();
			$coll = $coll->union($u);
		}
		return $coll;
	}

	public function byExp(?int $min, ?int $max) {
		if (($min <= 0) && ($max <= 0)) {
			return collect([]);
		}
		$coll = collect([]);
		if ($min !== null) {
			$coll = $coll->union(User::byExpMin($min)->get());
		}
		if ($max !== null) {
			$coll = ($min !== null) ? $coll->intersect(User::byExpMax($max)->get()) : $coll->union(User::byExpMax($max)->get());
		}
		return $coll;
	}

	public function bySalesTotal(?int $min, ?int $max) {
		if (($min <= 0) && ($max <= 0)) {
			return collect([]);
		}
		return User::all()->filter(function($user, $key) use ($min, $max) {
			$avg = $user->sales_total_avg();
			if (($min !== null) && ($max !== null) && ($avg >= $min) && ($avg <= $max)) {
				return true;
			}
			else if (($min !== null) && ($avg >= $min)) {
				return true;
			}
			else if (($max !== null) && ($avg <= $max)) {
				return true;
			}
			return false;
		});
	}

	public function bySalesValue(?float $min, ?float $max) {
		if (($min <= 0.0) && ($max <= 0.0)) {
			return collect([]);
		}
		return User::all()->filter(function($user, $key) use ($min, $max) {
			$avg = $user->sales_value_avg();
			if (($min !== null) && ($max !== null) && ($avg >= $min) && ($avg <= $max)) {
				return true;
			}
			else if (($min !== null) && ($avg >= $min)) {
				return true;
			}
			else if (($max !== null) && ($avg <= $max)) {
				return true;
			}
			return false;
		});
	}
}
