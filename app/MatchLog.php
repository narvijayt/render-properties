<?php

namespace App;
use App\Match;
use Illuminate\Database\Eloquent\Model;

class MatchLog extends Model
{
	const PKEY = 'match_log_id';
	protected $primaryKey = self::PKEY;

    protected $casts = [
        'user_init' => 'int',
        'user_with' => 'int',
    ];

	protected $fillable = [
		'match_id',
		'user_init',
		'user_with',
		'match_action',
		'renew_id',
	];

	const USER1 = 'user_init';
	const USER2 = 'user_with';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user1() {
		return $this->belongsTo(User::class, self::USER1);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user2() {
		return $this->belongsTo(User::class, self::USER2);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function match() {
		return $this->belongsTo(MatchLog::class, Match::PKEY);
	}
	
		
	public function check_accept(){
	    	return $this->hasOne(Match::class)->where('match_action','=','accept');
	}
}
