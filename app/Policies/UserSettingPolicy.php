<?php

namespace App\Policies;

use App\User;
use App\UserSetting;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserSettingPolicy
{
	use HandlesAuthorization;

	/**
	 * Return model class for policy;
	 * @return string
	 */
	protected function policyModel(): string
	{
		return UserSetting::class;
	}

	/**
	 * Edit policy
	 *
	 * @param User $user
	 * @return bool
	 */
	public function change(User $user)
	{
		return $user->isAll('user');
	}
}
