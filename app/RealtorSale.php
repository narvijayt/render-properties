<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RealtorSale extends Model implements ISecurable
{
    use Securable;

	protected $primaryKey = "realtor_sales_id";

	protected $fillable = [
		'realtor_id',
		'sales_year',
		'sales_month',
		'sales_total',
		'created_at',
		'updated_at',
	];

    protected $casts = [
        'realtor_id' => 'int',
        'sales_year' => 'int',
        'sales_month' => 'int',
        'sales_total' => 'int',
    ];

	/**
	 * Fetch user record
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function realtor()
	{
		return $this->belongsTo(Realtor::class, 'realtor_id');
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
        return $query->join('realtors', 'realtors.realtor_id', '=', 'realtor_sales.realtor_id')
            ->where('realtors.user_id', $user->user_id);
    }
}
