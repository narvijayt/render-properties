<?php

namespace App\Providers;

use App\Services\Matching\Matching;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class MatchingServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		App::bind('matching', function() {
			return new Matching;
		});
	}
}
