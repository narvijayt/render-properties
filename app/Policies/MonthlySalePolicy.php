<?php

namespace App\Policies;

use App\User;
use App\MonthlySale;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonthlySalePolicy
{
	use HandlesAuthorization;
	use HandlesBouncerAuth {
		edit as traitEdit;
	}

	/**
	 * Return class for policy
	 * @return string
	 */
	protected function policyModel(): string
	{
		return MonthlySale::class;
	}

	/**
	 * edit policy
	 *
	 * @param User $user
	 * @return bool
	 */
	public function edit(User $user)
	{
		return $user->isA('user')
			&& $user->isA('realtor', 'broker');
	}
}
