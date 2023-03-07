<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfileViolation extends Model
{
	const PKEY = 'user_profile_violation_id';
	protected $primaryKey = self::PKEY;

	protected $fillable = [
		'reported_by_id',
		'subject_id',
		'report',
		'resolved',
		'resolved_by_id',
	];

    protected $casts = [
        'reported_by_id' => 'int',
        'subject_id' => 'int',
        'resolved_by_id' => 'int',
    ];

	/**
	 * Get the user who reported the violation
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function reporter()
	{
		return $this->belongsTo(User::class, 'reported_by_id', 'user_id');
	}

	/**
	 * Get the user who is the subject of the violation
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function subject()
	{
		return $this->belongsTo(User::class, 'subject_id', 'user_id');
	}

	/**
	 * Get the user who resolved the violation
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function resolver()
	{
		return $this->belongsTo(User::class, 'resolved_by_id', 'user_id');
	}
}
