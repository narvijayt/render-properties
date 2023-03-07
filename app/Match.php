<?php

namespace App;

use App\Enums\MatchActionType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Watson\Rememberable\Rememberable;
use App\User;
use App\MatchLog;

class Match extends Model
{
	use SoftDeletes, UuidPrimaryKey, Rememberable;

	const PKEY = 'match_id';

	protected $primaryKey = self::PKEY;

	public $dates = [
		'deleted_at',
	];

    protected $casts = [
        'user_id1' => 'int',
        'user_id2' => 'int',
    ];

    protected $fillable = [
        'match_id',
        'user_id1',
        'user_type1',
        'accepted_at1',
        'user_id2',
        'user_type2',
        'accepted_at2',
    ];

	const USER1 = 'user_id1';
	const TYPE1 = 'user_type1';
	const USER2 = 'user_id2';
	const TYPE2 = 'user_type2';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function renewal()
	{
		return $this->hasOne(MatchRenewal::class, self::PKEY, self::PKEY);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user1() {
		return $this->belongsTo(User::class, self::USER1);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user2() {
		return $this->belongsTo(User::class, self::USER2);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function logs() {
		return $this->hasMany(MatchLog::class, self::PKEY);
	}

	/**
	 * Get the opposite party in the match
	 *
	 * @param User $user
	 * @return User|bool|mixed
	 */
	public function getOppositeParty(User $user)
	{
		if ((int)$user->user_id === (int)$this->user_id1) {
			return $this->user2;
		} else if ((int)$user->user_id === (int)$this->user_id2) {
			return $this->user1;
		}

		return false;
	}

	/**
	 * Check if the match has been confirmed
	 *
	 * @return bool
	 */
	public function isAccepted()
	{
		return (
			$this->accepted_at1 !== null && $this->accepted_at2 !== null && $this->deleted_at === null
		);
	}

	/**
	 * Check if the given user has confirmed the match
	 * @param User $user
	 * @return bool
	 */
	public function isAcceptedBy(User $user)
	{
		if (($this->user_id1 === $user->user_id && $this->accepted_at1 !== null)
			|| ($this->user_id2 === $user->user_id && $this->accepted_at2 !== null)) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the match is deleted
	 * @return bool
	 */
	public function isDeleted()
	{
		return $this->deleted_at !== null;
	}

	/**
	 * Check if the match is accpeted and not deleted
	 *
	 * @return bool
	 */
	public function isActive()
	{
		return (
			$this->isAccepted() && !$this->isDeleted()
		);
	}

	/**
	 * Get all matches for a given users
	 *
	 * @param User $user
	 * @param bool $trashed
	 * @return Collection
	 */
	public static function findForUser(User $user, $trashed = false)
	{
		$query = Match::where('user_id1', $user->user_id)
			->orWhere('user_id2', $user->user_id);

		if ($trashed) {
			$query->withTrashed();
		}

		$matches = $query->get();

		return $matches;
	}

	/**
	 * Find all existing matches for the given users
	 *
	 * @param $user1
	 * @param $user2
	 * @return Match|null
	 */
	public static function findForUsers(User $user1, User $user2, $trashed = false)
	{
		if ($user1->user_id === $user2->user_id) {
			return null;
		}

		/** @var Collection $matches */
		$query = Match::where('user_id1', $user1->user_id)
			->orWhere('user_id2', $user1->user_id);

		if ($trashed) {
			$query->withTrashed();
		}

		$matches = $query->get();

		$matches = $matches->filter(function(Match $match) use ($user2) {
			return (
				$match->user_id1 === $user2->user_id || $match->user_id2 === $user2->user_id
			);
		});

		return $matches->first();
	}

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
	 * Create a renewal request for the current model
	 * @param User $user
	 * @return MatchRenewal
	 */
	public function requestRenewal(User $user)
	{
		DB::beginTransaction();
		try {
			$renewal = MatchRenewal::create([
				'match_id' => $this->match_id,
				'user_id1' => $user->user_id,
				'accepted_at1' => Carbon::now(),
				'user_id2' => $this->getOppositeParty($user)->user_id,
			]);

			$this->log($user, MatchActionType::RENEW);
		} catch(\Exception $e) {
			DB::rollBack();
			return false;
		}
		DB::commit();

		return $renewal;
	}

	/**
	 * Replace the existing model and replace it with the given instance
	 *
	 * @param Match $match
	 * @return Match
	 */
	public function replaceWith(Match $match)
	{
		$this->forceDelete();

		$match->save();

		return $match;
	}

	/**
	 * Log a match action
	 *
	 * @param User $user
	 * @param $action
	 * @param null $renewalId
	 * @return \App\MatchLog
	 */
	public function log(User $user, $action, $renewalId = null)
	{
		return MatchLog::create([
			'match_id' => $this->match_id,
			'user_init' => $user->user_id,
			'user_with' => $this->getOppositeParty($user)->user_id,
			'match_action' => $action,
			'renew_id'		=> $renewalId,
		]);
	}

	public function save(array $options = [])
	{
		$match = Match::findForUsers($this->user1, $this->user2);

		if ($match !== null && $match->match_id !== $this->match_id) {
			throw new \Exception('A match already exists for the given users');
		}

		parent::save($options);
	}
	
	
	/**************Relation for broker listing**************/
	 public function matchuserbeoker(){
	     return $this->belongsTo('App\User', 'user_id1','user_id');
	 }

	 public function matchrelatordata(){
	     return $this->belongsTo('App\User', 'user_id2','user_id');
	 }
	 
	 /*******************End relation****************/

    public function match_log_broker(){
	     return $this->belongsTo('App\MatchLog','match_id', 'match_id');
	 }
	 
	   public function accept_log(){
	     return $this->belongsTo('App\MatchLog','match_id', 'match_id')->where('match_action', '=', 'accept');
	 }
	 
}
