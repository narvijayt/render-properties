<?php

namespace App\Http\Controllers\Pub;

use App\Http\Controllers\Controller;
use DB;

class HomeController extends Controller
{
	public function index()
	{
		$realtorCount = DB::table('users')->where('user_type', 'realtor')->count();
		$brokerCount = DB::table('users')->where('user_type', 'broker')->count();

		return view('home', compact('users', 'realtorCount', 'brokerCount'));
	}
}
