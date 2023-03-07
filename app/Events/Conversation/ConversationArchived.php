<?php

namespace App\Events\Conversation;

use App\User;
use App\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConversationArchived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\User
     */
    public $user;

    /**
     * @var \App\Conversation
     */
    public $conv;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Conversation $conv)
    {
        $this->user = $user;
        $this->conv = $conv;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('conversation.'.$this->conv);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $users = [];
        $subs = $this->conv->subscribers;
        if (!empty($subs)) foreach ($subs as $sub) {
            $users[] = $sub->user_id;
        }
        return ['user' => $this->user->user_id, 'conversation' => $this->conv->conversation_id, 'subscribers' => $users];
    }
}
