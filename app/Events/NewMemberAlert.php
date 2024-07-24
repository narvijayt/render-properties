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
use DB;

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
        $registeredMembersQuery = User::where(['state' => $this->user->state]);
        if($this->user->user_type == "broker"){
            $registeredMembersQuery->whereRaw("( (user_type = 'vendor' and payment_status = 1) OR (user_type = 'realtor' and (mobile_verified = 1 OR verified = true) ) ) ");
        }else if($this->user->user_type == "realtor"){            
            $registeredMembersQuery->whereIn('user_type', ["vendor", "broker"])->where(['payment_status' => 1]);
        }else if($this->user->user_type == "vendor"){
            $registeredMembersQuery->whereRaw("( (user_type = 'broker' and payment_status = 1) OR (user_type = 'realtor' and (mobile_verified = 1 OR verified = true)) ) ");
        }

        $this->registeredMembers = $registeredMembersQuery->get();
        // dd($this->registeredMembers);
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
