<?php

namespace App\Events\Conversation;

use API\Transformers\MessageTransformer;
use App\Message;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\Fractal\Fractal;

class NewMessageNotifyUser implements ShouldBroadcastNow
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * @var \App\Message
	 */
	public $msg;

	/**
	 * @var \App\User
	 */
	public $user;

	/**
	 * Create a new event instance.
	 *
	 * @param Message $msg
	 * @return void
	 */
	public function __construct(Message $msg, User $user)
	{
		$this->msg = $msg;
		$this->user = $user;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
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
		$fractal = app()->make(Fractal::class);
		$transformer = app()->make(MessageTransformer::class);

		return $fractal->item($this->msg, $transformer, 'data')->toArray();
	}
}
