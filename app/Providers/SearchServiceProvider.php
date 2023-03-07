<?php

namespace App\Providers;

use App\Services\Matching\Search;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
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
		App::bind('search', function() {
			return new Search;
		});
	}
}
