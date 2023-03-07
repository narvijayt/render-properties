<?php
/**
 * Created by PhpStorm.
 * User: jeremycloutier
 * Date: 8/25/17
 * Time: 1:47 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait UuidPrimaryKey
{
	/**
	 * Hook into the creating method to generate a uuid primary key
	 * on model creation.
	 */
	public static function boot()
	{
		parent::boot();

		static::creating(function(Model $model) {
			$model->{$model->getKeyName()} = Uuid::uuid4()->toString();
		});
	}

	/**
	 * Override get incrementing
	 *
	 * @return bool
	 */
	public function getIncrementing()
	{
		return false;
	}
}