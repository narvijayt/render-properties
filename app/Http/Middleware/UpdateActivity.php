<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UpdateActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	/** @var \App\User $user */
    	$user = $request->user();

    	if(Auth::check() && $user) {
			$user->update_last_active();
		}

        return $next($request);
    }
}
