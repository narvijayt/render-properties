<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LeadNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $propertyForm;
    public $usersWithRoles;
    public $realtorCount;
    public $brokerCount;
    public $completeShortURL;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($propertyForm, $usersWithRoles, $realtorCount, $brokerCount, $completeShortURL)
    {
        $this->propertyForm = $propertyForm;
        $this->usersWithRoles = $usersWithRoles;
        $this->realtorCount = $realtorCount;
        $this->brokerCount = $brokerCount;
        $this->completeShortURL = $completeShortURL;
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
