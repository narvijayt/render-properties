<?php

namespace App\Policies;

use App\Conversation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
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
        return Conversation::class;
    }

    /**
     * Check view permissions on a conversation entity
     *
     * @param User $user
     * @param Conversation $conversation
     * @return bool
     */
    public function view(User $user, Conversation $conversation) : bool
    {
        return (
            $this->traitView($user, $conversation)
                && $conversation->subscribers->find($user->user_id) !== null
        );
    }

    /**
     * Check if user can create a message on the conversation
     *
     * @param User $user
     * @param Conversation $conversation
     * @return bool
     */
    public function createMessage(User $user, Conversation $conversation) : bool
    {
        return $conversation->subscribers->find($user->user_id) !== null;
    }

	/**
	 * Check if user can archive a conversation
	 *
	 * @param User $user
	 * @param Conversation $conversation
	 * @return bool
	 */
    public function archive(User $user, Conversation $conversation) : bool
	{
		return $conversation->subscribers->find($user->user_id) !== null;
	}
}
