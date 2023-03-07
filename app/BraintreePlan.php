<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BraintreePlan extends Model
{
	const PKEY = 'braintree_plan_id';

	protected $primaryKey = self::PKEY;

	protected $casts = [
	    'years_of_exp' => 'int',
    ];

	protected $fillable = [
		'name',
		'slug',
		'braintree_plan',
		'cost',
		'description',
		'billing_frequency',
	];

	/**
	 * Override getRouteKeyName method
	 *
	 * @return string
	 */
	public function getRouteKeyName()
	{
		return 'slug';
	}

	/**
	 * Get the billing cycle as a string
	 *
	 * @return string
	 */
	public function frequency()
	{
		switch($this->billing_frequency) {
			case 1:
				$freq = 'Monthly';
				break;
			case 12:
				$freq = 'Yearly';
				break;
			default:
				$freq = 'Monthly';
		}

		return $freq;
	}
}
