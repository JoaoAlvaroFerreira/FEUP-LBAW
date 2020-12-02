<?php

namespace App\Http\Middleware;

use App\Models\Attending;
use App\Models\Event;
use Closure;
use Auth;

class Attendee
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
        
        $attending = Attending::where('event_id',$id)->where('attendee_id',Auth::user()->id)->first();
        if($attending != null){
            return $next($request);
        }
        
        return redirect('/')->with('failure', 'You\'re not the event manager!'); 
    }
}
