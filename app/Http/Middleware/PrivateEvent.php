<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Event;

class PrivateEvent
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
        $id = $request->route('id');
        $event = Event::findOrFail($id);

        if (!$event->private_event) {
            return $next($request);
        } else {
            if(Auth::user() == null)
            return redirect('/')->with('failure', 'You don\'t have access to this event!');

            if(Auth::user()->id == $event->owner_id|| Auth::user()->isAttending($id) || Auth::user()->isInvited($id)) {
                return $next($request);
            }
        


            return redirect('/')->with('failure', 'You don\'t have access to this event!');
        }
    }
}
