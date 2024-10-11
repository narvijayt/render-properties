<?php

namespace App\Http\Controllers\Pub\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Profile\UserSettingsUpdateRequest;
use App\UserSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
	public function index()
	{
		$user = auth()->user();
		$settings = $user->settings;

		return view('pub.profile.settings.index', compact('user', 'settings'));
	}


	public function update(Request $request)
	{
		$this->authorize('change', UserSetting::class);

		UserSetting::updateOrCreate([
			'user_id' => auth()->user()->user_id,
		], $request->only([
			'match_by_states',
			'match_by_exp_min',
			'match_by_exp_max',
			'match_by_sales_total_min',
			'match_by_sales_total_max',
			'email_receive_conversation_messages',
			'email_receive_match_requests',
			'email_receive_match_suggestions',
			'email_receive_review_messages',
			'email_receive_email_confirmation_reminders',
		]));

		flash('Successfully Updated Your Settings')->success();

		return redirect()->back();
	}

}
