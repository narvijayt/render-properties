<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorMeta extends Model
{
    //
    const PRIMARY_KEY = 'id';
    const USER_ID = 'userId';
    protected $primaryKey = self::PRIMARY_KEY;
    protected $table = 'vendor_metadetails';

    public function user(){
        return $this->hasOne(User::class, self::USER_ID, User::PKEY);
    }
}
