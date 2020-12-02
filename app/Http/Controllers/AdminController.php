<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\Event;


class AdminController extends Controller
{
    
    
    public function admin_user_list(){
        return view('admin.user_list');
    }

    public function admin_comment_list(){
        return view('admin.comment_list');
    }

    public function admin_event_list(){
        return view('admin.event_list');
    }

    


    public function delete_report($report_id)
    {
        $report = Report::findOrFail($report_id);
        $report->delete();

        return redirect('/admin_comment_list')->with('success', 'Report has been deleted successfully');
    }

    public function ban_user($id){

        $user = User::findOrFail($id);
        $user->removed = true;

       
    }

    public function remove_event($id){

        $event = Event::findOrFail($id);

        $event->removed = true;

       
    }

    
    
}
