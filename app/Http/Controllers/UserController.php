<?php

namespace App\Http\Controllers;

use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attending;
use App\Models\Invited;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use UploadTrait;


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);


        return view('pages.user', ['user' => $user]);
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.edit_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255'
        ]);

        if (!password_verify($request->get('password'), $user->password)) {
            return redirect('/edit_user/' . $id)
            ->withErrors(['The password used is wrong.']);
        }
     

        $user->name = $request->get('name');
        if ($request->has('bio')) {
            $user->bio = $request->get('bio');
            if($request->get('bio') != null)
            $request->validate([
                'bio' => 'max:255 | string',
            ]);
        }
        $user->email = $request->get('email');

        if ($request->get('new-password') != null)
            $user->password = bcrypt($request->get('new-password'));

        // Check if a profile image has been uploaded
        if ($request->has('photo')) {
            // Get image file
            $image = $request->file('photo');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')) . '_' . time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $user->photo = $filePath;
        }


        $user->save();


        return redirect('/user/' . $id)->with('user_update', 'User has been updated!');
    }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

     
    public function ban(Request $request)
    {
        $user = User::findOrFail($request->get('ban_id'));
        $user->banned = true;
        $user->save();
        return back()->with('success', 'User has been banned');
    }

    public function delete(Request $request)
    {
        $user = User::findOrFail($request->get('delete_id'));
        $user->delete();

        return back()->with('success', 'Account has been deleted successfully');
    }

    public function deleteNotifications(Request $request)
    {
        Notification::where('target_id', $request->get('notification_id'))->delete();
        return redirect('/user/' . $request->get('notification_id'))->with('success', 'Notifications have been cleared');
    }

    public function deleteInvitations(Request $request)
    {
        Invited::where('invited_id', $request->get('invitation_id'))->delete();
        return redirect('/user/' . $request->get('invitation_id'))->with('success', 'Invitations have been cleared');
    }
}
