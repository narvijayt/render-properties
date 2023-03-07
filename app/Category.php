<?php

namespace App;

use App\Enums\AvatarSizeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use App\Category;
use Storage;
class Category extends Model
{
	use SoftDeletes;

    const PRIMARY_KEY = 'id';

    protected $primaryKey = self::PRIMARY_KEY;
    protected $table = 'vendor_category';

	protected $fillable = [
		'user_id',
		'category_id',
	];

    protected $casts = [
        'user_id' => 'int',
    ];

    /**
	 * Get the user who owns this avatar.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function vendor_category()
	{
		return $this->belongsTo(User::class, 'user_id', 'user_id');
	}

}
