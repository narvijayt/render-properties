<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Realtor extends Model
{
	protected $primaryKey = "realtor_id";

	protected $fillable = [
		'years_exp',
		'active',
		'created_at',
		'updated_at',
	];

    protected $casts = [
        'years_exp' => 'int',
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
     * Fetch Realtor Sales records
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sales()
    {
        return $this->hasMany(RealtorSale::class, 'realtor_id');
    }
}
