<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MatchPurchase extends Model
{
	const PKEY = 'match_purchase_id';
	protected $primaryKey = self::PKEY;

	protected $fillable = [
		'user_id',
		'type',
		'quantity',
		'braintreee_transaction_id',
	];

    protected $casts = [
        'quantity' => 'int',
    ];

	/**
	 * Only include match purchases for the given user
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param User $user
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeUser(Builder $query, User $user)
	{
		return $query->where('user_id', $user->user_id);
	}

	/**
	 * Get the total number of available matches for a given user
	 *
	 * @param User $user
	 * @return integer
	 */
	public static function totalForUser(User $user)
	{
		return self::query()->user($user)->sum('quantity');
	}
}
