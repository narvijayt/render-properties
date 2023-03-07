<?php

namespace App\Services\Matching;

use App\MatchRenewal;
use App\User;
use App\Match;
use App\MatchLog;
use App\MatchRenew;
use App\Enums\MatchActionType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class Matching {
	/**
	 * @param User $from
	 * @param User $to
	 * @return bool|mixed
	 */
	public function request(User $from, User $to) {
		// Validate User object and user type integrity
		if (
			($from === $to) 
			|| ($from->user_type === null) 
			|| ($to->user_type === null) 
			|| ($from->user_type === $to->user_type)
		) {
			return false;
		}

		$match = DB::transaction(function() use ($from, $to) {
			// Generate UUID key (Eloquent workaround)
			$mid = Uuid::uuid4();

			// Build Match object
			$obj = Match::create([
				'match_id' 			=> $mid,
				'user_id1' 			=> $from->user_id,
				'user_type1' 		=> $from->user_type,
				'accepted_at1' 		=> Carbon::now(),
				'user_id2' 			=> $to->user_id,
				'user_type2' 		=> $to->user_type,
				'accepted_at2' 		=> null,
			]);

			// Build MatchLog object
			$log = MatchLog::create([
				'match_id'		=> $obj->match_id,
				'user_init'		=> $from->user_id,
				'user_with'		=> $to->user_id,
				'match_action'	=> MatchActionType::INITIAL,
			]);

			// Return Match object if successful
			return $obj;
		}) ?? false;

		return $match;
	}

	/**
	 * Accept Match by id for user
	 *
	 * @param string $id
	 * @param User $user
	 * @return bool|mixed
	 */
	public function accept(string $id, User $user) {
		// Validate UUID
		if (!Uuid::isValid($id)) return false;

		return DB::transaction(function() use ($id, $user) {
			// Fetch Match object, build MatchLog object
			$obj = Match::find($id);
			$log = new MatchLog();
			$log->match_id = $obj->match_id;
			$log->match_action = MatchActionType::ACCEPT;

			// Check for User #1
			if (($obj->user_id1 === $user->user_id) && ($obj->accepted_at1 === null)) {
				$obj->accepted_at1 = Carbon::now();
				$obj->save();
				$log->user_init = $user->user_id;
				$log->user_with = $obj->user2->user_id;
			}
			// Check for User #2
			else if (($obj->user_id2 === $user->user_id) && ($obj->accepted_at2 === null)) {
				$obj->accepted_at2 = Carbon::now();
				$obj->save();
				$log->user_init = $user->user_id;
				$log->user_with = $obj->user1->user_id;
			}
			else return false;

			return $log->save();
		});
	}

	/**
	 * Reject match by id for user
	 *
	 * @param string $id
	 * @param User $user
	 * @return bool|mixed
	 */
	public function reject(string $id, User $user) {
		// Validate UUID
		if (!Uuid::isValid($id)) return false;

		return DB::transaction(function() use ($id, $user) {
			// Fetch Match object, build MatchLog object
			$obj = Match::find($id);
			$log = new MatchLog();
			$log->match_id = $obj->match_id;
			$log->match_action = MatchActionType::REJECT;

			// Check for User #1
			if ($obj->user_id1 === $user->user_id) {
				$log->user_init = $user->user_id;
				$log->user_with = $obj->user2->user_id;
			}
			// Check for User #2
			else if ($obj->user_id2 === $user->user_id) {
				$log->user_init = $user->user_id;
				$log->user_with = $obj->user1->user_id;
			}
			else return false;

			return $obj->forceDelete() && $log->save();
		});
	}

	/**
	 * Remove match by id for user
	 *
	 * @param string $id
	 * @param User $user
	 * @return bool|mixed
	 */
	public function remove(string $id, User $user) {
		// Validate UUID
		if (!Uuid::isValid($id)) return false;

		return DB::transaction(function() use ($id, $user) {
			// Fetch Match object, build MatchLog object
			$obj = Match::find($id);
			$log = new MatchLog();
			$log->match_id = $obj->match_id;
			$log->match_action = MatchActionType::REMOVE;

			// Check for User #1
			if (($obj->user_id1 === $user->user_id) && ($obj->accepted_at1 !== null)) {
				$log->user_init = $user->user_id;
				$log->user_with = $obj->user2->user_id;
			}
			// Check for User #2
			else if (($obj->user_id2 === $user->user_id) && ($obj->accepted_at2 !== null)) {
				$log->user_init = $user->user_id;
				$log->user_with = $obj->user1->user_id;
			}
			else return false;

			return $obj->delete() && $log->save();
		});
	}

	/**
	 * Find an existing match for the given users
	 *
	 * @param User $user1
	 * @param User $user2
	 * @param bool $trashed
	 * @return \App\Match|false
	 */
	public function findForUsers(User $user1, User $user2, $trashed = false)
	{
		$matches = Match::findForUsers($user1, $user2, $trashed);

		return $matches->count() > 0 ? $matches->first() : false;
	}

	/**
	 * Find an existing renewal request for the given users
	 *
	 * @param User $user1
	 * @param User $user2
	 * @param bool $trashed
	 * @return \App\Match|false
	 */
	public function findRenewalForUsers(User $user1, User $user2, $trashed = false)
	{
		$matches = MatchRenewal::findForUsers($user1, $user2, $trashed);

		return $matches !== null ? $matches : false;
	}

	/**
	 * Request a renewal for the provided match
	 *
	 * @param string $id
	 * @param User $user
	 * @return $this|bool|\Illuminate\Database\Eloquent\Model
	 */
	public function requestRenewal(string $id, User $user)
	{
		if (!Uuid::isValid($id)) return false;

		DB::beginTransaction();

		try {
			$match = Match::withTrashed()->find($id);

			$match->log($user, MatchActionType::RENEW);

			$renewal = MatchRenewal::create([
				'match_id' => $id,
				'user_id1' => $user->user_id,
				'accepted_at1' => Carbon::now(),
				'user_id2' => $match->getOppositeParty($user)->user_id,
			]);
		} catch(Exception $e) {
			DB::rollback();
		}

		DB::commit();

		return $renewal;
	}

	/**
	 * Convert a renewal request into a new match
	 *
	 * @param string $id
	 * @param User $user
	 * @return bool|mixed
	 */
	public function renew(string $id, User $user) {
		if (!Uuid::isValid($id)) return false;

		DB::beginTransaction();

		try {
			$renewal = MatchRenewal::find($id);

			$originalMatch = Match::find($renewal->match_id);
			$oppUser = $originalMatch->getOppositeParty($user);

			$originalMatch->forceDelete();

			$newMatch = $this->request($user, $oppUser);

			$originalMatch->log($user, MatchActionType::RENEW, $newMatch->match_id);

			$renewal->forceDelete();
		} catch (Exception $e) {
			DB::rollback();
		}

		DB::commit();

		return $newMatch;
	}

	/**
	 * Log an action for a match
	 *
	 * @param Match $match
	 * @param User $from
	 * @param User $to
	 * @param string $action
	 * @param null $renewId
	 * @return $this|\Illuminate\Database\Eloquent\Model
	 */
	public function logAction(Match $match, User $from, User $to, string $action, $renewId = null)
	{
		return MatchLog::create([
			'match_id' => $match->match_id,
			'user_init' => $from->user_id,
			'user_width' => $to->user_id,
			'match_action' => $action,
			'renew_id'		=> $renewId,
		]);
	}
}
