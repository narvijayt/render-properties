<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PartialRegistration extends Model
{
    use SoftDeletes;
    const PKEY = 'partial_registration_id';
    protected $primaryKey = self::PKEY;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'provider',
        'provider_id',
        'remember_token',
    ];

    protected $dates = ['deleted_at'];

}
