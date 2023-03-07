<?php

namespace App;

use App\Enums\AvatarSizeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use App\Category;
use Storage;

class ConversationUser extends Model
{
    use SoftDeletes;

	const PKEY = 'conversation_id';
	
	protected $primaryKey = self::PKEY;
	protected $table = 'conversation_user';

}
