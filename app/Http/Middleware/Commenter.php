<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Comment;
use App\Models\Event;

class Commenter
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
        $comment = Comment::where("id",$request->route('comment_id'))->first();
        $event = Event::findOrFail($request->route('id'));
        if(Auth::user()->id == $comment->commenter_id || Auth::user()->isAdmin() || Auth::user()->id == $event->owner_id){
            return $next($request);
        }
        
        
        return redirect('/')->with('failure', 'You don\'t have the permissions for this action!'); 
     
    }
}
