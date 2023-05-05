<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserSubscriptions extends Model
{
    //

    protected $_table = "user_subscriptions";


    /**
     * Get the user that owns the phone.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
