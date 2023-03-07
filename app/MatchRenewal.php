<?php

namespace App;

use App\Enums\MatchActionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MatchRenewal extends Model
{
	use SoftDeletes;

	const PKEY = 'match_id';
	protected $primaryKey = self::PKEY;
	protected $table = 'match_renewal';
	public $incrementing = false;

	protected $dates = [
		'deleted_at',
	];

	protected $fillable = [
		'match_id',
		'user_id1',
		'user_id2',
		'accepted_at1',
		'accepted_at2',
	];

    protected $casts = [
        'user_id1' => 'int',
        'user_id2' => 'int',
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user1() {
		return $this->belongsTo(User::class, 'user_id1');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user2() {
		return $this->belongsTo(User::class, 'user_id2');
	}

	/**
	 * Limit query to only those match renewals that are pending
	 *
	 * @param Builder $query
	 * @param User|null $user
	 * @param bool $deleted
	 * @return Builder
	 */
	public static function scopePending(Builder $query, User $user = null, $deleted = false)
	{
		$query->whereNull('accepted_at2');

		if ($user !== null) {
			$query->where('user_id2', $user->user_id);
		}

		if($deleted !== true) {
			$query->whereNull('deleted_at');
		}

		return $query;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function match() {
		return $this->belongsTo(Match::class, self::PKEY, Match::PKEY)->withTrashed();
	}

	/**
	 * Get the opposite party in the match
	 *
	 * @param User $user
	 * @return User|bool|mixed
	 */
	public function getOppositeParty(User $user)
	{
		if ($user->user_id === $this->user_id1) {
			return $this->user2;
		} else if ($user->user_id === $this->user_id2) {
			return $this->user1;
		}

		return false;
	}

	/**
	 * Find all match renews for the given users
	 *
	 * @param User $user1
	 * @param User $user2
	 * @return MatchRenewal
	 */
	public static function findForUsers(User $user1, User $user2, $trashed = false)
	{
		if ($user1->user_id === $user2->user_id) {
			return collect([]);
		}

		$query = MatchRenewal::where('user_id1', $user1->user_id)
			->orWhere('user_id2', $user1->user_id);

		if ($trashed) {
			$query->withTrashed();
		}
		$renewals = $query->get();

		$renewals = $renewals->filter(function(MatchRenewal $match) use ($user2) {
			return (
				$match->user_id1 === $user2->user_id || $match->user_id2 === $user2->user_id
			);
		});

		return $renewals->first();
	}

	/**
	 * Check if the match renew has been accepted by the provided user
	 *
	 * @param User $user
	 * @return bool
	 */
	public function isAcceptedBy(User $user)
	{
		if (
			($user->user_id === $this->user_id1 && $this->accepted_at1 !== null)
				|| ($user->user_id === $this->user_id2 && $this->accepted_at2 !== null)
		) {
			return true;
		}

		return false;
	}

	/**
	 * Accept the match renew on behalf of the provided user.
	 *
	 * @param User $user
	 * @return Match|bool
	 */
	public function accept(User $user)
	{
		$existingMatch = $this->match;

		DB::beginTransaction();
		try {
			$this->accepted_at2 = Carbon::now();
			$this->save();

			$newMatch = new Match();
			$newMatch->fill([
				'user_id1' => $this->user_id1,
				'user_type1' => $this->user1->user_type,
				'user_id2' => $this->user_id2,
				'user_type2' => $this->user2->user_type,
				'accepted_at1' => $this->accepted_at1,
				'accepted_at2'	=> $this->accepted_at2,
			]);

			$existingMatch->replaceWith($newMatch);

			$existingMatch->log($user, MatchActionType::RENEW, $newMatch->match_id);
			$newMatch->log($user, MatchActionType::ACCEPT);
			$this->delete();
		} catch (\Exception $e) {
			DB::rollBack();

			return false;
		}
		DB::commit();

		return $newMatch;
	}

	/**
	 * Reject the match renewal on behalf of the given user
	 *
	 * @param User $user
	 * @return bool|null
	 */
	public function reject(User $user)
	{
		$match = $this->match;

		$match->log($user, MatchActionType::REJECT);

		return $this->forceDelete();
	}
}
