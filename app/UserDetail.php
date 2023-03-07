<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model implements ISecurable
{
    use Securable;

	protected $primaryKey = "user_detail_id";

	protected $dates = [
		'dob',
	];

	protected $fillable = [
		'user_id',
        'register',
        'verify',
        'lock',
        'dob',
		'city',
		'state',
		'zip',
		'bio',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'user_id' => 'int',
    ];

    /**
     * Fetch user record
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Add a security query to ensure that the user only received their own records
     *
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function securityQuery(Builder $query, User $user): Builder
    {
        return $query->join('users', 'users.user_id', '=', 'user_details.user_id')
            ->where('users.user_id', $user->user_id);
    }
}
