<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    //
    // use HasFactory;

    protected $table = 'user_verification';

    protected $fillable = ['user_id', 'otp', 'expire_at'];
}
