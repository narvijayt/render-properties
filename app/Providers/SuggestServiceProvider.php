<?php

namespace App\Providers;

use App\Services\Matching\Suggest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class SuggestServiceProvider extends ServiceProvider
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
		App::bind('suggest', function() {
			return new Suggest;
		});
	}
}
