<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use app\User;

class RealtorDetail extends Model
{
    //
    const PRIMARY_KEY = 'id';
    const USER_ID = 'user_id';
    protected $primaryKey = self::PRIMARY_KEY;
    protected $table = 'realtor_details';

    public function user(){
        return $this->hasOne(User::class, self::USER_ID, User::PKEY);
    }
}
