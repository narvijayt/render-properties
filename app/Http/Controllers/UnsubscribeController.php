<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UnsubscribeController extends Controller
{
	/**
	 * Unsubscribe the user from receiving mail
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
    public function index(Request $request)
    {
        if (!$request->get('uid') || !$request->get('type')) 
        {
            throw new \Exception('Invalid Request');
        }
        $user = User::where('uid', $request->get('uid'))
        ->firstOrFail();
        $settings = $user->settings;
        switch($request->get('type')) {
        case config('mail.email_types.conversation_messages'):
            $settings->email_receive_conversation_messages = false;
            $settings->save();
        break;
        case config('mail.email_types.match_requests'):
            $settings->email_receive_match_requests = false;
            $settings->save();
        break;
        case config('mail.email_types.match_suggestions'):
            $settings->email_receive_match_suggestions = false;
            $settings->save();
        break;
        case config('mail.email_types.review_messages'):
            $settings->email_receive_review_messages = false;
            $settings->save();
        break;
        case config('mail.email_types.weekly_update'):
            $settings->email_receive_weekly_update_email = false;
            $settings->save();
        break;
        case config('mail.email_types.email_confirmation_reminder'):
            $settings->email_receive_email_confirmation_reminders = false;
            $settings->save();
        break;
            default:
            throw new \Exception('Invalid Type');
        }
    return view('unsubscribe.index');
    }
}
