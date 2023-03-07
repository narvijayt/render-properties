<?php

namespace App;

use App\Enums\AvatarSizeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use App\Banner;
use Storage;
class Banner extends Model
{
	use SoftDeletes;

    const PRIMARY_KEY = 'id';

    protected $primaryKey = self::PRIMARY_KEY;
    protected $table = 'advertisement_banner';

	protected $fillable = [
		'user_id',
		'banner_image',
	];

    protected $casts = [
        'user_id' => 'int',
    ];



}
