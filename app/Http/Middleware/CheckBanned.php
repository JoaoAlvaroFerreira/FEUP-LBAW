<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckBanned
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
        if (Auth::user() != null) {
           
            
            if(Auth::user()->banned){
            
            Auth::logout();
            return redirect()->route('login')->withMessage("User banned");
            
            }
        }

        return $next($request);
    }
}
