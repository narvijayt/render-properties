<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\User;

class NewMemberAlert
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
	 * @var User
	 */
    public $user;
    
    /**
	 * @var object
	 */
    public $registeredMembers;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
        $user_types = [];
        if($this->user->user_type == "broker"){
            $user_types = ['vendor','realtor'];
            $whereClause = ['zip' => $this->user->zip];
        }else if($this->user->user_type == "realtor"){
            $user_types = ['vendor','broker'];
            $whereClause = ['state' => $this->user->state, 'payment_status' => 1];
        }else if($this->user->user_type == "vendor"){
            $user_types = ['realtor','broker'];
            $whereClause = ['zip' => $this->user->zip];
        }

        $this->registeredMembers = User::whereIn('user_type', $user_types)->where($whereClause)->get();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
