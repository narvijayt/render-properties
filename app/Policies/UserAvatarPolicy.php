<?php

namespace App\Policies;

use App\UserAvatar;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserAvatarPolicy
{
    use HandlesAuthorization;
    use HandlesBouncerAuth;

    /**
     * Return model class for policy;
     * @return string
     */
    protected function policyModel(): string
    {
        return UserAvatar::class;
    }
}
