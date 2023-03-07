<?php

namespace App\Policies;

use App\Realtor;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RealtorPolicy
{
    use HandlesAuthorization;
    use HandlesBouncerAuth  {
        create as traitCreate;
    }

    /**
     * Return class for policy
     * @return string
     */
    protected function policyModel(): string
    {
        return Realtor::class;
    }

    /**
     * Create policy
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isA('user')
            && $user->realtor()->count() === 0
            && $this->traitCreate($user);
    }

    /**
     * Determine if the user can view their own realtor profile index page
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->isA('user');
    }
}
