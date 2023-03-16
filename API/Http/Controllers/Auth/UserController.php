<?php

namespace API\Http\Controllers\Auth;

use API\Http\Controllers\Controller;
use API\Transformers\UserTransformer;

class UserController extends Controller
{
	protected $transformerClass = UserTransformer::class;
	/**
	 * Override default ability map
	 *
	 * @return array
	 */
	protected function resourceAbilityMap()
	{
		return [];
	}

	/**
	 * Return the currently authenticated user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user = $this->getUser();

		return $this->createItemResponse($user)
			->respond();
	}
}
