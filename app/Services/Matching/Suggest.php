<?php

namespace App\Services\Matching;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Suggest
{
	protected $baseQuery = "
		SELECT 
			user_info.user_id
		FROM (
			-- Wrapped sub query to allow usage in the where clauses below
			SELECT
				u.user_id,
				u.first_name,
				u.last_name,
				u.username,
				u.email,
				u.user_avatar_id,
				u.user_type,
				u.years_of_exp,
				u.state,
				u.city,
				u.monthly_sales,
				(
					-- Select total number of matches for the user
					SELECT SUM(quantity) AS matches_total
					FROM match_purchases mp
					WHERE mp.user_id = u.user_id
				),
				(
					-- Select the total number of matches used by the user
					SELECT COUNT(*) AS matches_used
					FROM (
							SELECT *
							FROM matches m
							WHERE user_id1 = u.user_id
							UNION
							SELECT *
							FROM matches m
							WHERE user_id2 = u.user_id
						) AS matches
				)
			FROM users u
		) user_info
		WHERE
		(
			CASE
				WHEN user_info.user_type = 'broker' THEN 1
				ELSE user_info.matches_total - user_info.matches_used
			END
		) > 0
		-- WHERE (user_info.matches_total - user_info.matches_used) > 0 -- Must have available matches
			AND user_info.user_type != ?
	";

	public function byUser(User $user, $count = 5)
	{
		$settings = $user->settings;

		$query = $this->baseQuery . "
				AND ((user_info.years_of_exp >= ? AND user_info.years_of_exp <= ?) OR (user_info.years_of_exp IS NULL))
				AND ((user_info.monthly_sales >= ? AND user_info.monthly_sales <= ?) OR (user_info.monthly_sales IS NULL))
				AND user_info.state = ANY(?) -- Passed a postgres style array from the model {SC,NC}
	  			AND user_info.user_id != ANY( -- Filter out any existing matches
				(
					SELECT array(
						SELECT 0 as user_id -- provide default value for array to prevent any() from failing on empty array
						UNION
						SELECT user_id2 as user_id
						FROM matches
						WHERE user_id1 = ?
						UNION
						SELECT user_id1 as user_id
						FROM matches
						WHERE user_id2 = ?
						)
					)::BIGINT[] -- Cast to array
				)
			ORDER BY random()
			LIMIT ?;
		";

		$res = DB::select($query, [
			(string) $user->user_type,
			(int) $settings->match_by_exp_min,
			(int) $settings->match_by_exp_max,
			(int) $settings->match_by_sales_total_min,
			(int) $settings->match_by_sales_total_max,
			(string) '{'.implode(', ', $settings->match_by_states).'}',
			(int) $user->user_id,
			(int) $user->user_id,
			(int) $count,
		]);

		$ids = array_map(function($v) {
			return $v->user_id;
		}, $res);

		$suggestedUsers = User::whereIn('user_id', $ids)->get();
		if (count($res) < $count) {
			// get remainder of matches from randomly generated list
			$fillerUsers = $this->randomByUser($user, $count - count($res), $ids);
			$suggestedUsers = $suggestedUsers->merge($fillerUsers);
		}
		return $suggestedUsers;
	}

	public function logUsers(Collection $col)
	{
		$col->each(function($v) {
			dump($v->full_name());
		});
	}

	public function randomByUser(User $user, $count = 1, array $exclude = [0])
	{
		$settings = $user->settings;
		$exclude = !empty($exclude) ? $exclude : [0];
		$query = $this->baseQuery . "
	  			AND user_info.user_id != ANY( -- Filter out any existing matches
				(
					SELECT array(
						SELECT 0 as user_id -- provide default value for array to prevent any() from failing on empty array
						UNION
						SELECT user_id2 as user_id
						FROM matches
						WHERE user_id1 = ?
						UNION
						SELECT user_id1 as user_id
						FROM matches
						WHERE user_id2 = ?
						)
					)::BIGINT[] -- Cast to array
				)
				AND user_info.user_id != ANY(?)
			ORDER BY random()
			LIMIT ?;
		";

		$res = DB::select($query, [
			(string) $user->user_type,
			(int) $user->user_id,
			(int) $user->user_id,
			(string) '{0,'.implode(',', $exclude).'}',
			(int) $count,
		]);

		$ids = array_map(function($v) {
			return $v->user_id;
		}, $res);

		return User::whereIn('user_id', $ids)->get();
	}

//	public function byUser(User $user)
//	{
//		if ($user === null) {
//			return collect([]);
//		}
//		$matches = $user->matches();
//
//		$coll = collect([]);
//		$coll_tmp = self::byStates($user->settings->match_by_states);
//		$coll_tmp = $coll_tmp->diff($matches);
//		if ($coll_tmp->count() > 0) {
//			$coll_new = ($coll->count() == 0) ? $coll->union($coll_tmp) : $coll->intersect($coll_tmp);
//			$coll = ($coll_new->count() > 0) ? $coll_new : $coll;
//		}
//
//		$coll_tmp = self::byExp($user->settings->match_by_exp_min, $user->settings->match_by_exp_max);
//		$coll_tmp = $coll_tmp->diff($matches);
//		if ($coll_tmp->count() > 0) {
//			$coll_new = ($coll->count() == 0) ? $coll->union($coll_tmp) : $coll->intersect($coll_tmp);
//			$coll = ($coll_new->count() > 0) ? $coll_new : $coll;
//		}
//
//		$coll_tmp = self::bySalesTotal($user->settings->match_by_sales_total_min,
//			$user->settings->match_by_sales_total_max);
//		$coll_tmp = $coll_tmp->diff($matches);
//		if ($coll_tmp->count() > 0) {
//			$coll_new = ($coll->count() == 0) ? $coll->union($coll_tmp) : $coll->intersect($coll_tmp);
//			$coll = ($coll_new->count() > 0) ? $coll_new : $coll;
//		}
//
//		$coll_tmp = self::bySalesValue($user->settings->match_by_sales_value_min,
//			$user->settings->match_by_sales_value_max);
//		$coll_tmp = $coll_tmp->diff($matches);
//		if ($coll_tmp->count() > 0) {
//			$coll_new = ($coll->count() == 0) ? $coll->union($coll_tmp) : $coll->intersect($coll_tmp);
//			$coll = ($coll_new->count() > 0) ? $coll_new : $coll;
//		}
//
//		return $coll;
//	}

//	public function byState(string ...$states)
//	{
//		if (empty($states)) {
//			return collect([]);
//		}
//		return self::byStates($states);
//	}
//
//	public function byStates(?array $states)
//	{
//		if (empty($states)) {
//			return collect([]);
//		}
//		$coll = collect([]);
//		foreach ($states as $s) {
//			$u = User::byState($s)->get();
//			$coll = $coll->union($u);
//		}
//		return $coll;
//	}
//
//	public function byExp(?int $min, ?int $max)
//	{
//		if (($min <= 0) && ($max <= 0)) {
//			return collect([]);
//		}
//		$coll = collect([]);
//		if ($min !== null) {
//			$coll = $coll->union(User::byExpMin($min)->get());
//		}
//		if ($max !== null) {
//			$coll = ($min !== null) ? $coll->intersect(User::byExpMax($max)->get()) : $coll->union(User::byExpMax($max)->get());
//		}
//		return $coll;
//	}
//
//	public function bySalesTotal(?int $min, ?int $max)
//	{
//		if (($min <= 0) && ($max <= 0)) {
//			return collect([]);
//		}
//		return User::all()->filter(function ($user) use ($min, $max) {
//			$avg = $user->sales_total_avg();
//			if ($avg >= $min && $avg <= $max) {
//				return true;
//			}
////			else if (($min !== null) && ($avg >= $min)) {
////				return true;
////			}
////			else if (($max !== null) && ($avg <= $max)) {
////				return true;
////			}
//			return false;
//		});
//	}
//
//	public function bySalesValue(?float $min, ?float $max)
//	{
//		if (($min <= 0.0) && ($max <= 0.0)) {
//			return collect([]);
//		}
//		return User::all()->filter(function ($user, $key) use ($min, $max) {
//			$avg = $user->sales_value_avg();
//			if ($avg >= $min && $avg <= $max) {
//				return true;
//			}
////			else if (($min !== null) && ($avg >= $min)) {
////				return true;
////			}
////			else if (($max !== null) && ($avg <= $max)) {
////				return true;
////			}
//			return false;
//		});
//	}
}
