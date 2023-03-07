<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Vendor extends Model
{
	protected $primaryKey = "vendor_id";

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

   
}
