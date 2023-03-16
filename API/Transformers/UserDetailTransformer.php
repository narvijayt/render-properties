<?php

namespace API\Transformers;

use App\UserDetail;
use League\Fractal\TransformerAbstract;

class UserDetailTransformer extends TransformerAbstract
{
	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'user',
	];

	/**
	 * A Fractal transformer.
	 *
	 * @return array
	 */
	public function transform(UserDetail $detail)
	{
		return [
			'id'			=> $detail->user_detail_id,
			'user_id'		=> $detail->user_id,
			'city'			=> $detail->city,
			'state'			=> $detail->state,
			'zip'			=> $detail->zip,
			'bio'			=> $detail->bio,
			'register'		=> (string) $detail->register,
			'verify'		=> $detail->verify === null ? null : (string) $detail->verify,
			'locked'		=> $detail->lock === null ? null : (string) $detail->lock,
			'created_at'	=> (string) $detail->created_at,
			'updated_at'	=> (string) $detail->updated_at,
		];
	}

	/**
	 * Include the user relation
	 *
	 * @param UserDetail $detail
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeUser(UserDetail $detail)
	{
		return $this->item($detail->user, new UserTransformer());
	}
}
