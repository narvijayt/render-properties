<?php

namespace App\Events\Conversation;

use API\Transformers\MessageTransformer;
use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\Fractal\Fractal;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Message
     */
    public $msg;

    /**
     * @var \App\Conversation
     */
    public $conv;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $subs;

    /**
     * Create a new event instance.
     *
     * @param Message $msg
     * @return void
     */
    public function __construct(Message $msg)
    {
        $this->msg = $msg;
        $this->conv = $msg->conversation;
        $this->subs = $msg->conversation->subscribers;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.Conversation.'.$this->conv->conversation_id);
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
