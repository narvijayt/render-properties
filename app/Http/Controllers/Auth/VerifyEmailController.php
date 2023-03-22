<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\User;
use Mail;
Use Auth;
use App\Http\Traits\AutoMatchTrait;

class VerifyEmailController extends Controller
{

	// use AutoMatchTrait Trait
	use AutoMatchTrait;
	
	/**
	 * Takes in the data of verify and finds user it belongs
	 * to then fires off the verified function of Users
	 *
	 * @param $token
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function verify($token)
	{
		/** @var User $user */
		$user= User::where('email_token', $token)
			->where('verified', false)
			->first();

		if ($user) {
			$user->verify_email();
			flash('Thank you, your email has been verified')->success();
		} else {
			flash('The email verification link you provided is no longer valid')->error();
			return redirect()->route('home');
		}

		if (auth()->guest()) {
		    if($user->user_type == "broker" ){
				if($user->payment_status == 0){
					return redirect('/login');
				}else{
					Auth::login($user, true);	
				}
			}else{
				Auth::login($user, true);
			}
		}
		
		if($user->user_type == "broker" ){
	        $response = $this->sendAutoMatchRequests($user->user_id);
	    }else if($user->user_type == "realtor"){
			$response = $this->findAutoLocalLenders($user->user_id);
		}

		return redirect()->route('pub.profile.index');
	}

	public function resendVerification()
	{
		$user = auth()->user();

		$email = new EmailVerification($user);
		Mail::to($user->email)->send($email);

		flash('A new verification email has been sent to '. $user->email)->success();

        return back()->with('emailmsg', 'An email with a verification link has been sent to the email address you provided. If you do not see the email in your inbox, please check in your spam folder.');
	}
}
