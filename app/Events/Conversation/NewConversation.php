<?php

namespace App\Events\Conversation;

use API\Transformers\ConversationTransformer;
use App\Conversation;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\Fractal\Fractal;

class NewConversation implements ShouldBroadcastNow
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * @var \App\Conversation
	 */
	public $conversation;

	/**
	 * @var \App\User
	 */
	public $user;

	/**
	 * Create a new event instance.
	 *
	 * @param User $user
	 * @param Conversation $conversation
	 */
	public function __construct(User $user, Conversation $conversation)
	{
		$this->conversation = $conversation;
		$this->user = $user;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return PrivateChannel
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('App.User.'.$this->user->user_id);
	}

	/**
	 * Get the data to broadcast.
	 *
	 * @return array
	 */
	public function broadcastWith()
	{
		/** @var Fractal $fractal */
		$fractal = app()->make(Fractal::class);
		$transformer = app()->make(ConversationTransformer::class);

		return $fractal->item($this->conversation, $transformer, 'data')->toArray();
	}
}
