<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BrokerSale extends Model implements ISecurable
{
	use Securable;

	protected $primaryKey = "broker_sales_id";

	protected $fillable = [
		'broker_id',
		'sales_year',
		'sales_month',
		'sales_total',
		'created_at',
		'updated_at',
	];

    protected $casts = [
        'broker_id' => 'int',
        'sales_year' => 'int',
        'sales_month' => 'int',
        'sales_total' => 'int',
    ];

	/**
	 * Fetch user record
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function broker()
	{
		return $this->belongsTo(Broker::class, 'broker_id');
	}

	/**
	 * Create a query to secure the model and ensure that only the users own records
	 * are returned
	 *
	 * @param Builder $query
	 * @param User $user
	 * @return Builder
	 */
	public function securityQuery(Builder $query, User $user): Builder
	{
		return $query->join('brokers', 'brokers.broker_id', '=', 'broker_sales.broker_id')
			->where('brokers.user_id', $user->user_id);
	}

}
