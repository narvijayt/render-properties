<?php

namespace App\Http\Middleware;

use Closure;

class HoneyBot
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
       if($request->isMethod('POST') && count($request->honey_pot) != 0 ){

        return redirect('vendor-register');
        }
        return $next($request);
    }
}
