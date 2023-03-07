<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class SearchPathProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	$searchPath = config('database.connections.pgsql.search_path');
        DB::statement("SET search_path = $searchPath");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
