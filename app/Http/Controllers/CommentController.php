<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadTrait;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommentController extends Controller
{

    use UploadTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request)
    {
        $request->validate([
            'commenter_id' => 'required',
            'event_id' => 'required',
            'content' => 'required'
        ]);

        $comment = new Comment([

            'commenter_id' => $request->get('commenter_id'),
            'event_id' => $request->get('event_id'),
            'content' => $request->get('content'),
            'removed' => false

        ]);

        if ($request->file('comment_image') != null) {
            // Get image file
            $image = $request->file('comment_image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('commenter_id')) . '_' . time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user image path in database to filePath
            $comment->photo = $filePath;
        }

        $comment->save();

        $event = Event::findOrFail($request->get('event_id'));
        $target_id = intval($event->owner_id);
        $event_id = $event->id;

        $notification = new Notification([
            'target_id' => $target_id,
            'type' => 0,
            'origin_id' => $event_id,
            'description' => "Comment made in your event: " . $request->get('content')
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
                    'description' => "Comment made in an event you're attending: " . $request->get('content')
                ]);


                $notification->save();
            }
        }

        return redirect('/event/' . $request->get("event_id"))->with('success', 'Comment made!');
    }

    public function delete($event_id, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $comment->delete();

        return redirect('/event/' . $event_id)->with('success', 'Comment has been deleted successfully');
    }
}
