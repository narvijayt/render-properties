<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProvider extends Model
{
    const PKEY = 'user_provider_id';
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
        'user_id',
    ];

    protected $casts = [
        'user_id' => 'int',
    ];

	/**
	 * Fetch the user relation
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
