<?php

namespace App;

use App\Enums\AvatarSizeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use App\Category;
use Storage;
class VendorDetails extends Model
{
	use SoftDeletes;

    const PRIMARY_KEY = 'id';

    protected $primaryKey = self::PRIMARY_KEY;
    protected $table = 'vendor_detail';

	protected $fillable = [
		'user_id',
		'vendor_industry',
		'vendor_coverage_unit',
		'vendor_service'
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
