<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MonthlySale extends Model implements ISecurable
{
	use Securable;

	protected $table = 'sales_per_month';

	const PKEY = 'user_sales_id';
	protected $primaryKey = self::PKEY;

	protected $fillable = [
		'user_id',
		'sales_year',
		'sales_month',
		'sales_total',
		'sales_value',
		'created_at',
		'updated_at',
	];

    protected $casts = [
        'user_id' => 'int',
        'sales_year' => 'int',
        'sales_month' => 'int',
        'sales_total' => 'int',
        'sales_value' => 'int',
    ];

	/**
	 * Fetch user record
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class, User::PKEY);
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
		return $query->join('users', 'users.user_id', '=', 'sales_per_month.user_id')
			->where('users.user_id', $user->user_id);
	}

	public function formattedDate()
	{
		$date = Carbon::createFromDate($this->sales_year, $this->sales_month);

		return $date->format('F, Y');
	}
}
