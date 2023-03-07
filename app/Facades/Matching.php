<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Matching extends Facade {
	protected static function getFacadeAccessor() {
		return 'matching';
	}
}
