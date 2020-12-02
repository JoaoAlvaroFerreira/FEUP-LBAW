<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Poll;
use App\Models\Event;
use App\Models\Vote;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PollController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'poll_option_0' => 'required',
        ]);

        $poll = new Poll([

            'question' => $request->get('question'),
            'event_id' => $request->get('event_id'),
            'target_id' => $request->get('target_id')
        ]);
        $poll->save();
        $aux_array_raw = array(
            0=> $request->get('poll_option_0'),
            1=> $request->get('poll_option_1'),
            2=> $request->get('poll_option_2'),
            3=> $request->get('poll_option_3'),
            4=> $request->get('poll_option_4'),
            5=> $request->get('poll_option_5'),
            6=> $request->get('poll_option_6'));
       
        $aux_array = array_unique($aux_array_raw);
      foreach($aux_array as $i => $item){
            if( $item != null){
                $option = new Option([
                    'poll_id' => $poll->id,
                    'content' => $item ,
                ]);
                $option->save();
            }
        }

   

        $event = Event::findOrFail($request->get('event_id'));
        $target_id = intval($event->owner_id);
        $event_id = $event->id;

        $notification = new Notification([
            'target_id' => $target_id,
            'type' => 0,
            'origin_id' => $event_id,
            'description' => "Poll made in an event you're attending. "
        ]);

        $notification->save();

        $attendants = $event->attending;
        foreach ($attendants as $attendant) {

            $target_id = intval($attendant->attendee_id);
            if ($target_id != $event->owner_id) {
                $notification = new Notification([
                    'target_id' => $target_id,
                    'type' => 0,
                    'origin_id' => $event_id,
                    'description' => "Poll made in an event you're attending."
                ]);


                $notification->save();
            }
        }

        return redirect('/event/' . $request->get("event_id"))->with('success', 'Comment made!');
    }

    public function delete($event_id, $poll_id)
    {
        $poll = Poll::findOrFail($poll_id);
        $poll->delete();

        return redirect('/event/' . $event_id)->with('success', 'Poll has been deleted successfully');
    }

    public function vote(Request $request)
    {
        
        $vote = new Vote(['poll_id' =>  $request->get('poll_id'), 'content' =>  $request->get('content'),'voter_id'=>$request->get('voter_id')]);
        $vote->save();
       
        $poll = Poll::findOrFail($request->get('poll_id'));
        $options = Option::where('poll_id', $request->get('poll_id'))->get();
        $poll_html = "<div class='commenttext'><h2 class='polltxt'>". $poll->question. "</h2>
        <table>";

        foreach ($options as $option) {

            $poll_html = $poll_html.
             "<tr>

              <td>". $option->content ."</td>
              <td class=commenttext><b> - Votes(". $option->votes() .") </td>
             

            </tr>";
         } 

        $poll_html = $poll_html."</table></div>";

        return response()->json(array('poll' => $poll_html), 200);
    }

}
