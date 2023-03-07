<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBlock extends Model
{
    const PKEY = 'user_block_id';
	protected $primaryKey = self::PKEY;

	protected $fillable = [
		'user_id',
		'blocked_user_id',
		'reason',
	];

    protected $casts = [
        'user_id' => 'int',
        'blocked_user_id' => 'int',
    ];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'user_id');
	}

	public function blocked_user()
	{
		return $this->belongsTo(User::class, 'blocked_user_id', 'user_id');
	}
}
