<?php

namespace API\Transformers;

use App\Conversation;
use App\User;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class ConversationTransformer extends TransformerAbstract
{
	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'user',
		'subscribers',
	];

	protected $defaultIncludes = [
		'messages',
		'subscribers'
	];

	/**
	 * A Fractal transformer.
	 *
	 * @return array
	 */
	public function transform(Conversation $convo)
	{
		$transform = [
			'conversation_id' => (int)$convo->conversation_id,
			'user_id' => (int)$convo->user_id,
			'conversation_title' => (string)$convo->conversation_title,
			'created_at' => is_null($convo->created_at) ? null : (string)$convo->created_at,
			'updated_at' => is_null($convo->updated_at) ? null : (string)$convo->updated_at,
			'deleted_at' => is_null($convo->deleted_at) ? null : (string)$convo->deleted_at,
		];


		return $transform;
	}

	public function getUserEmbedData(User $user): array
	{
		return [
			'user_id'		=> $user->user_id,
			'username'		=> $user->username,
			'first_name'	=> $user->first_name,
			'last_name'		=> $user->last_name,
			'avatar' 		=> $user->avatarUrl(),
			'archived'		=> is_null($user->pivot->archived) ? null : $user->pivot->archived,
			'last_read'		=> is_null($user->pivot->last_read) ? null : $user->pivot->last_read,
		];
	}

    public function includeUser(Conversation $convo)
    {
        $user = $convo->user;

        return $this->item($user, new UserTransformer());
    }

    public function includeSubscribers(Conversation $convo)
    {
        $subscribers = $convo->subscribers;
        return $this->collection($subscribers, new SubscriberTransformer());
    }

	public function includeMessages(Conversation $convo)
	{
		$messages = $convo->messages;
		return $this->collection($messages, new MessageTransformer());
	}
}
