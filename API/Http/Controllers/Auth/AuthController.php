<?php

namespace API\Http\Controllers\Auth;

use API\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$credentials = $request->only('email', 'password');

		try {
			if (!$token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'Invalid Credentials'], 401);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'could not create token'], 500);
		}

		return response()->json(compact('token'));
	}
}
