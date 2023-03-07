<?php

namespace App;

use App\Enums\AvatarSizeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use App\Category;
use Storage;
class Package extends Model
{
	use SoftDeletes;

    const PRIMARY_KEY = 'id';

    protected $primaryKey = self::PRIMARY_KEY;
    protected $table = 'vendor_packages';

	protected $fillable = [
		'package_type',
		'package_name',
		'price'
	];

    protected $casts = [
        'id' => 'int',
    ];


	
	
	
	/**
	 * Get the user who owns this avatar.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */


}
