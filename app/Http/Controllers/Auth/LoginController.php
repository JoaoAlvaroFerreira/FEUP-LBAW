<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUser(){
        return $request->user();
    }

    public function home() {
        return redirect('login');
    }

    public function password_recovery_new_pass(Request $request){

        $validator = Validator::make($request->all(),[
            'code_input' => 'required|in:'.$request->get('code')
        ]);
        if ($validator->fails()) {
            return view('auth.password_recovery_code_input',['user' => $request->get('user'), 'code' => $request->get('code')])
                ->withErrors(['The code you used doesn\'t match the code sent in the e-mail. A new code was sent.']);
        }

       
        return view('auth.password_recovery_new_pass',['user' => $request->get('user')]);
    }
    
    public function password_recovery_email_input(){
        return view('auth.password_recovery_email_input');
    }



    public function password_recovery_code_input(Request $request){

        $user = User::where('email',$request->get('email'))->first();

        if($user == null){
            return redirect('login');
        }
        $code = Str::random(6);
        $to_name = $user->name;
        $to_email = $user->email;
        $data = array('name'=>$to_name, 'code' => $code);
        Mail::send('auth.mail', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
        ->subject('Meetcamp Password Recovery');
        $message->from('lbaw2024@gmail.com','Meetcamp');
     
        });

        return view('auth.password_recovery_code_input',['user' => $user->email, 'code' => $code]);
    }

    public function password_update(Request $request){
        
       
        $user = User::where('email',$request->get('user'))->first();

        if($user == null){
            return redirect('/FAQ');
        }
            

        $validator = Validator::make($request->all(),[
            'password' => 'required|string|min:6|confirmed'
        ]);
        if ($validator->fails()) {
            return view('auth.password_recovery_new_pass',['user' => $request->get('user')])
                ->withErrors(['The passwords don\'t match.']);
        }

       

        $user->password = bcrypt($request->get('password'));
        $user->save();
     
        
        return redirect('login')->with('success','Password has been updated');
    }
    

}
