<?php

namespace App\Policies;

use App\Message;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;
    use HandlesBouncerAuth {
        view as traitView;
    }

    /**
     * Return class for policy
     * @return string
     */
    protected function policyModel(): string
    {
        return Message::class;
    }

    /**
     * Check view permissions on a message entity
     *
     * @param User $user
     * @param Message $message
     * @return bool
     */
    public function view(User $user, Message $message) : bool
    {
        return (
            $this->traitView($user, $message)
                && $message->conversation->subscribers->find($user->user_id) !== null
        );
    }
}
