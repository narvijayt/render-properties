<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
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
            'id' 				=> $user->user_id,
			'username' 			=> $user->username,
			'email' 			=> $user->email,
			'active' 			=> $user->active,
			'first_name' 		=> $user->first_name,
			'last_name' 		=> $user->last_name,
			'registration_date' => $user->created_at,
        ];
    }

	public function includeDetail(User $user)
	{
		$detail  = $user->detail;

		return $this->item($detail, new UserDetailTransformer);
	}
}
