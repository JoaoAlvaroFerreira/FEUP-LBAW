<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attending;
use App\Traits\UploadTrait;
use App\Models\Event;
use App\Models\Tags;
use App\Models\Event_Image;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    use UploadTrait;


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function generateTags(string $tags, int $event_id)
    {

        
        $res = explode(" ", $tags);
        $result = array_unique($res);
        foreach ($result as $tag) {

            $tag_save = new Tags(['event_id' => $event_id, 'tag' => $tag]);
            $tag_save->save();

        }
    }

    public function deleteTags(int $event_id)
    {
        $tags = Tags::where('event_id', $event_id);
        $tags->delete();

    }

    public function generateImage(string $filePath, int $event_id)
    {

        $event_images = new Event_Image(['event_id' => $event_id, 'image_url' => $filePath]);
        $event_images->save();
    }


    public function store(Request $request)
    {
        $end_date = null;
        if ($request->get('end_date') != null) {
            $end_date = $request->get('end_date');
        }
        if ($request->get('private_event') != null) {
            $private_event = true;
        } else $private_event = false;
        $request->validate([
            'event_name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'location' => 'required'
        ]);

        if($request->get('start_date') > $request->get('end_date') && $request->get('end_date') != null)
            return redirect('/create_event')->with('fail', 'Start date must be before end date!');

        if($request->get('start_date') == $request->get('end_date') && $request->get('end_date') != null)
            return redirect('/create_event')->with('fail', 'Start date and end date must not be the same!');
    
        if($request->get('start_date') < today())
            return redirect('/create_event')->with('fail', 'Start date must be after today!');

        if($request->get('price') != 0 && $request->get('paypal') == null)
            return redirect('/create_event')->with('fail', 'For paid events you must provide a PayPal account!');
            

        $event = new Event([
            'event_name' => $request->get('event_name'),
            'owner_id' => $request->get('owner_id'),
            'description' => $request->get('description'),
            'paypal'=> $request->get('paypal'),
            'price' => $request->get('price'),
            'start_date' => $request->get('start_date'),
            'end_date' => $end_date,
            'private_event' => $private_event,
            'location' => $request->get('location'),
        ]);

        $event->save();

        if($request->get('tags') != null)
        $this->generateTags($request->get('tags'), $event->id);

        if ($request->file('event_image') != null) {
            $image = $request->file('event_image');
            // Make a image name based on event id
            $name = Str::slug($request->input('event_name')) . '_' . time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            
            $this->generateImage($filePath, $event->id);
        } 
        return redirect('/')->with('success', 'Event saved!');
    }

    public function addImage(Request $request){
        if ($request->file('event_image') != null) {
            $image = $request->file('event_image');
            // Make a image name based on event id
            $name = Str::slug($request->input('event_name')) . '_' . time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            
            $this->generateImage($filePath, $request->input('event_id'));
        } 
        return redirect('/event/'.$request->input('event_id'))->with('success', 'Event has been updated');
    }

    public function removeImages(Request $request){

      Event_Image::where('event_id', $request->input('event_id'))->delete();


        return redirect('/event/'.$request->input('event_id'))->with('success', 'Event has been updated');
    }


    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $this->deleteTags($id);
      
        $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start_date' => 'required',
            'location' => 'required|string|max:255'
        ]);

        if($request->get('start_date') > $request->get('end_date') && $request->get('end_date') != null)
            return redirect('/event/'.$id.'/edit')->with('fail', 'Start date must be before end date!');

        if($request->get('start_date') == $request->get('end_date') && $request->get('end_date') != null)
            return redirect('/event/'.$id.'/edit')->with('fail', 'Start date and end date must not be the same!');

        if($request->get('start_date') < today())
            return redirect('/create_event')->with('fail', 'Start date must be after today!');

        if($request->get('price') != 0 && $request->get('paypal') == null)
            return redirect('/event/'.$id.'/edit')->with('fail', 'For paid events you must provide a PayPal account!');
            

        $event->event_name = $request->get('event_name');
        $event->description = $request->get('description');
        $event->price = $request->get('price');
        $event->paypal = $request->get('paypal');
        $event->start_date = $request->get('start_date');
        
        if($request->get('tags') != null)
        $this->generateTags($request->get('tags'), $event->id);
        
        $end_date = null;
        if ($request->get('end_date') != null) {
            $end_date = $request->get('end_date');
        }
        if ($request->get('private_event') != null) {
            $private_event = true;
        } else $private_event = false;


        $event->end_date = $end_date;
        $event->private_event = $private_event;
        $event->location = $request->get('location');      

        $event->save();

        $attendants = $event->attending;
        foreach($attendants as $attendant){
        $target_id = $attendant->attendee_id;
        
        $notification = new Notification([
            'target_id' => $target_id,
            'type'=> 1,
            'origin_id'=> $event->id,
            'description'=> $event->event_name." has changed, check it out!"
        ]);
        
        $notification->save();
        }


        return redirect('/event/'.$id)->with('success', 'Event has been updated');
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
       

        $attendants = $event->attending;

        foreach($attendants as $attendant){
        $target_id = $attendant->attendee_id;
        
        $notification = new Notification([
            'target_id' => $target_id,
            'type'=> 2,
            'origin_id'=> $event->id,
            'description'=> $event->event_name." has been deleted."
        ]);
        
        $notification->save();
        }

        $event->delete();

        return redirect('/')->with('event_deleted', 'Event has been deleted successfully.');
    }

    
    

    public function attend(Request $request)
    {
        
       
        $event_id = intval($request->input('event_id'));

        $event = Event::findOrFail($event_id);

        if($event->start_date < today()){
            return redirect("/event/$event_id")->with('failure', 'Can\'t join events that already happened!');

        }

        $attend = new Attending(['event_id' => $event_id, 'attendee_id' => $request->input('user_id')]);
        $attend->save();
        return redirect("/event/$event_id")->with('success', 'Event saved!');
    }


    public function leave(Request $request)
    {
        $event_id = intval($request->input('event_id'));
        $user_id = intval($request->input('user_id'));

        Attending::where('event_id', $event_id)->where('attendee_id', $user_id)->delete();

        return redirect("/event/$event_id")->with('success', 'Event saved!');
    }


    public function edit_event($id){
      
            $event = Event::findOrFail($id);    
            return view('pages.edit_event', ['event' => $event]);    
    }


    
}
