<?php

namespace App;

use App\Enums\AvatarSizeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAvatar extends Model
{
	use SoftDeletes;

    const PRIMARY_KEY = 'user_avatar_id';

    protected $primaryKey = self::PRIMARY_KEY;

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'user_id',
		'name',
		'original_name',
	];

    protected $casts = [
        'user_id' => 'int',
    ];

	/**
	 * Get the full path url for the avatar
	 *
	 * @param string $size
	 *
	 * @return string
	 */
    public function fullUrl(string $size = null)
	{
		$size = $size ? $size : AvatarSizeEnum::LARGE;
        list($filename, $extension) = explode('.', $this->name);
		$file = "{$filename}-{$size}.".config('upload.default_extension');
		//Azure Image Url
        //$liveurl = 'https://' . config('filesystems.disks.azure.name'). '.blob.core.windows.net/' . config('filesystems.disks.azure.container') . '/profile-pictures/' . $file;
        $localurl = public_path('profile_pictures/'.$this->name);
        //Azure image with size parameter
        //$azureUrl =  env('APP_URL').'/public/azure_'.$size.'/'.$file;
        $azure = env('APP_URL').'/profile_picture/'.$this->name;
        if(file_exists($localurl)){
            $url =  env('APP_URL').'/profile_pictures/'.$this->name;
        } else{
            $url = $azure;
        }
        return url($url);
        //return url(Config::get('upload.user_avatar_path'), $this->name);
	}

	/**
	 * Get the user who owns this avatar.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'user_id');
	}

}
