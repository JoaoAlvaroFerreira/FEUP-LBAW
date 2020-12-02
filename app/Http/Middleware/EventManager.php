<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Auth;

class EventManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   $id = $request->route('id');
        
        $event = Event::findOrFail($id);
        if(Auth::user()->id == $event->owner_id || Auth::user()->isAdmin()){
            return $next($request);
        }
        
        return redirect('/')->with('failure', 'You\'re not the event manager!'); 
    }
}
