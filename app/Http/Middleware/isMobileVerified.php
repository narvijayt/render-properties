<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isMobileVerified
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
        $user = Auth::user();
        if($user->mobile_verified != 1){
            return route('otp.sendnewotp', ['id' => $user->user_id]);
        }
        return $next($request);
    }
}
