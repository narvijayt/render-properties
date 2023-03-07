<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Mail;

class SetPasswordController extends Controller
{
    /**
     * Show Request Password Reset Form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Render | Request New Password';
        $page_description = 'Render';

        return view('auth.custom.email', compact('page_title', 'page_description'));
    }

    /**
     * Send Set New Password Email Link
     * 
     * @param Request $request
     */
    public function postEmail(Request $request){
        
        // $request->validate([
        //     'email' => 'required|email|exists:users',
        // ]);

        $this->validate($request, [
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send('auth.custom.verify',['token' => $token], function($message) use ($request) {
            $message->from('richard@realbrokerconnections.com','Render');
            $message->to($request->email);
            $message->subject('Set Account Password');
        });

        return back()->with('success', 'We have sent an email with a link to reset password, please check your email.');
    }


    public function getPassword($token) {

        return view('auth.custom.reset', ['token' => $token]);
     }
 
     public function updatePassword(Request $request)
     {
        $this->validate($request, [
             'email' => 'required|email|exists:users',
             'password' => 'required|string|min:6|confirmed',
             'password_confirmation' => 'required',
 
         ]);
 
         $updatePassword = DB::table('password_resets')
                             ->where(['email' => $request->email, 'token' => $request->token])
                             ->first();
 
         if(!$updatePassword)
             return back()->withInput()->with('error', 'Invalid token!');
 
           $user = User::where('email', $request->email)
                       ->update(['password' => Hash::make($request->password),'registered'=>1]);
 
           DB::table('password_resets')->where(['email'=> $request->email])->delete();
 
           return redirect('/login')->with('message', 'Your password has been changed!');
 
     }
}