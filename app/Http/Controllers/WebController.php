<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Poll;
use App\Models\Vote;
use App\Models\Option;
use App\Models\Report;
use App\Models\Invited;
use Illuminate\Http\Request;

class WebController extends Controller
{


    public function index()
    {

        return view('pages.home');
    }

    public function about()
    {

        return view('pages.about');
    }

    public function faq()
    {

        return view('pages.faq');
    }


    public function search()
    {

        return view('pages.search');
    }


    public function event($id)
    {
        $event = Event::findOrFail($id);


        return view('pages.event', ['event' => $event]);
    }

    
    public function event_ticket($id)
    {
        $event = Event::findOrFail($id);
        
        return view('pages.ticket', ['event' => $event]);
    }

    public function dropdown( )
    {

        return view('partials.dropdown');
    }

    public function create_event()
    {

        return view('pages.create_event');
    }


    public function edit_user()
    {

        return view('pages.edit_user');
    }

    public function invite(Request $request)
    {



        $invite = Invited::where('invited_id', $request->get('invited_id'))->where('inviter_id', $request->get('inviter_id'))->where('event_id', $request->get('event_id'))->first();
        $msg = "Invite had already been sent!";

        if ($invite == null) {
            $attend = new Invited(['invited_id' =>  $request->get('invited_id'), 'inviter_id' =>  $request->get('inviter_id'), 'event_id' => $request->get('event_id')]);
            $attend->save();

            $msg = "Invite has been sent!";
        }


        return response()->json(array('id' => $request->get('invited_id'), 'msg' => $msg), 200);
    }

    public function report(Request $request)
    {
        
        $report = new Report(['report_note' =>  $request->get('report_note'), 'comment_id' =>  $request->get('comment_id')]);
        $report->save();
        $msg = "Report Made";

        return response()->json(array('msg' => $msg), 200);
    }


    public function categories(Request $request)
    {
        return view('pages.categories',['requested_tag'=>$request->get('tag')]);
    }

    public function showEvents(Request $request)
    {
        return view('pages.home',['sort'=>$request->get('sort')]);
    }

    


}
