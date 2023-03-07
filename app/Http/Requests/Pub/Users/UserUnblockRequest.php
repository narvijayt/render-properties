<?php

namespace App\Http\Requests\Pub\Users;

use App\Policies\UserPolicy;
use Illuminate\Foundation\Http\FormRequest;

class UserUnblockRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param UserPolicy $policy
	 * @return bool
	 */
	public function authorize(UserPolicy $policy)
	{
		return $policy->unblock(auth()->user(), request()->route('user'));
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [];
	}
}
