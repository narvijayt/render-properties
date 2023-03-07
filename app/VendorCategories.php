<?php

namespace App;

use App\Enums\AvatarSizeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Storage;
class VendorCategories extends Model
{
	use SoftDeletes;

    const PRIMARY_KEY = 'id';

    protected $primaryKey = self::PRIMARY_KEY;
    protected $table = 'category';

	protected $fillable = [
		'name'
	];

    protected $casts = [
        'id' => 'int',
    ];

}
