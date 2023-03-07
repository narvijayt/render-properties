<?php

namespace App\Http\Controllers\Pub\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pub\Profile\DetailUpdateRequest;
use App\Http\Requests\Pub\Profile\PasswordUpdateRequest;
use App\UserDetail;
use Auth;
use Carbon\Carbon;
use Hash;

class DashboardController extends Controller
{
	/**
	 * Profile Index action
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
//        $user = Auth::user();
//
//	    $this->authorize('view', $user);
//
//		return view('pub.profile.index', compact('user'));

		return redirect()->route('pub.profile.detail.edit');
	}
}
