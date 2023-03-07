<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfileView extends Model
{
    const PKEY = 'user_profile_views_id';
    protected $primaryKey = self::PKEY;

    public $timestamps = false;

    protected $fillable = [
    	'user_id',
		'viewer_id',
		'viewed_at',
	];


    public function user()
	{
    	return $this->belongsTo(User::class, 'user_id', User::PKEY);
	}

	public function viewer()
	{
		return $this->belongsTo(User::class, 'viewer_id', User::PKEY);
	}
}
