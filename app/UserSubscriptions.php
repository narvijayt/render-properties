<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Watson\Rememberable\Rememberable;
use App\User;

class UserSubscriptions extends Model
{
    //

    protected $_table = "user_subscriptions";

    const USER_ID = 'user_id';

    /**
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function user() {
		return $this->belongsTo(User::class, User::PKEY);
	}
}
