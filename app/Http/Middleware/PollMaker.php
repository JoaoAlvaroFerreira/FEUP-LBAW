<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Poll;
use App\Models\Event;

class PollMaker
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
        $poll = Poll::where("id",$request->route('poll_id'))->first();
        $event = Event::findOrFail($request->route('id'));
        if(Auth::user()->id == $poll->target_id || Auth::user()->isAdmin() || Auth::user()->id == $event->owner_id){
            return $next($request);
        }
        
        
        return redirect('/')->with('failure', 'You don\'t have the permissions for this action!'); 
     
    }
}
