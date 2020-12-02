<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class ProfileOwner
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
       
      
        if(Auth::user()->id == $request->route('id')){
            return $next($request);
        }
        
        
        return redirect('/')->with('failure', 'You\'re not the profile owner!'); 
     
    }
}
