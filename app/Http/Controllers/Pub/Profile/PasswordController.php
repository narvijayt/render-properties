<?php

namespace App\Http\Controllers\Pub\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Profile\PasswordUpdateRequest;

class PasswordController extends Controller
{
	/**
	 * Password index action
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
	    $this->authorize('edit', $this->auth->user());

		return view('pub.profile.password.index');
	}

	/**
	 * Password update action
	 *
	 * @param PasswordUpdateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(PasswordUpdateRequest $request)
	{
		$user = $this->auth->user();
		$this->authorize('edit', $user);

		$user->update([
			'password' => bcrypt($request->get('new_password'))
		]);

		flash('Password changed! Please login using your new password.')->success();
		$this->auth->logout();

		return redirect()->route('login');
	}
}
