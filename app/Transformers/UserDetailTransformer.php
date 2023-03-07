<?php

namespace App\Transformers;

use App\UserDetail;
use League\Fractal\TransformerAbstract;

class UserDetailTransformer extends TransformerAbstract
{
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
			'register'		=> $detail->register,
			'verify'		=> $detail->verify,
			'locked'		=> $detail->lock,
			'created_at'	=> $detail->created_at,
			'updated_at'	=> $detail->updated_at,
        ];
    }
}
