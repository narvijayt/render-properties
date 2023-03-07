<?php

namespace App\Policies;

use App\User;
use App\UserDetail;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserDetailPolicy
{
    use HandlesAuthorization;
    use HandlesBouncerAuth {
    	create as traitCrate;
	}

    /**
     * Return model class for policy;
     * @return string
     */
    protected function policyModel(): string
    {
        return UserDetail::class;
    }

	/**
	 * Create policy
	 *
	 * @param User $user
	 * @return bool
	 */
	public function create(User $user)
	{
		if ($user->detail()->count() !== 0) {
			$this->deny('You may only create one detail object per user');
		}

		return $user->isAll('user')
			&& $this->traitCreate($user);
	}
}
