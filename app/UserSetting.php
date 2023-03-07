<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
	const PKEY = 'user_settings_id';
	protected $primaryKey = self::PKEY;

	protected $fillable = [
		'user_id',
		'match_by_states',
		'match_by_exp_min',
		'match_by_exp_max',
		'match_by_sales_total_min',
		'match_by_sales_total_max',
		'email_receive_conversation_messages',
		'email_receive_match_requests',
		'email_receive_match_suggestions',
		'email_receive_review_messages',
	];


    protected $casts = [
        'user_idt ' => 'int',
        'match_by_exp_min' => 'int',
        'match_by_exp_max' => 'int',
        'match_by_sales_total_min' => 'int',
        'match_by_sales_total_max' => 'int',
		'email_receive_conversation_messages' => 'boolean',
		'email_receive_match_requests' => 'boolean',
		'email_receive_match_suggestions' => 'boolean',
		'email_receive_review_messages' => 'boolean',
    ];

	/**
	 * Get matches by state
	 *
	 * @param $value
	 * @return array|null
	 */
	public function getMatchByStatesAttribute($value) {
		$values = $value;
		if (empty($values)) {
			return [];
		}

		$values = substr($values, 1, -1);
		$values = explode(',', $values);

		return $values;
	}

	/**
	 * Serialize the match_by_states array into the postgres json format
	 *
	 * @param array $values
	 * @return void|null
	 */
	public function setMatchByStatesAttribute(array $values = []) {
		if (!is_array($values) || empty($values)) {
			$values = [];
		}

		$this->attributes['match_by_states'] = '{'.implode(',', $values).'}';
	}

	/**
	 * Fetch related User record
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user()
	{
		return $this->belongsTo(User::class, User::PKEY);
	}
}
