<?php

namespace API\Transformers;

use App\User;
use App\UserAvatar;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'detail'
	];

	/**
	 * A Fractal transformer.
	 *
	 * @return array
	 */
	public function transform(User $user)
	{

		return [
			'user_id' 			=> $user->user_id,
			'username' 			=> $user->username,
			'email' 			=> $user->email,
			'active' 			=> $user->active,
			'first_name' 		=> $user->first_name,
			'last_name' 		=> $user->last_name,
			'registration_date' => (string) $user->created_at,
			'avatar'			=> $user->avatarUrl(),
		];
	}

	/**
	 * Include the user detail relation
	 *
	 * @param User $user
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeDetail(User $user)
	{
		return [
			'id'			=> $user->user_id,
			'city'			=> $user->city,
			'state'			=> $user->state,
			'zip'			=> $user->zip,
			'bio'			=> $user->bio,
			'register'		=> $user->register_ts,
			'verify'		=> $user->verify_ts,
			'locked'		=> $user->lock_ts,
			'created_at'	=> $user->created_at,
			'updated_at'	=> $user->updated_at,
		];
	}
}
