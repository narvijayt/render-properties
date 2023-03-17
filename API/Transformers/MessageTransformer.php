<?php

namespace API\Transformers;

use App\Conversation;
use App\Message;
use Illuminate\Database\Eloquent\Builder;
use League\Fractal\TransformerAbstract;

class MessageTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected array $availableIncludes = [
        'user',
        'subscribers',
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Message $message)
    {
//        $user = $message->subscribers->find(auth()->user()->user_id);

        $transform = [
            'message_id'            => (int) $message->message_id,
            'conversation_id'       => (int) $message->conversation_id,
            'user_id'               => (int) $message->user_id,
            'message_text'          => (string) $message->message_text,
            'created_at'            => is_null($message->created_at) ? null : (string) $message->created_at,
            'updated_at'            => is_null($message->updated_at) ? null : (string) $message->updated_at,
            'deleted_at'            => is_null($message->deleted_at) ? null : (string) $message->deleted_at,
            'user_name'             => $message->user->full_name(),
        ];

        return $transform;
    }

    public function includeUser(Message $message)
    {
        $user = $message->user;

        return $this->item($user, new UserTransformer());
    }

    public function includeSubscribers(Message $message)
    {
        $subscribers = $message->subscribers;
        return $this->collection($subscribers, new SubscriberTransformer());
    }

    public function scopeForConversation(Builder $query, Conversation $conversation)
    {
        return $query->where('conversation_id', $conversation->conversation_id);
    }
}
