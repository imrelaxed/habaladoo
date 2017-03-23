<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserSubscribedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $plan;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($me, $pickedPlan)
    {
        $this->user = $me;
        $this->plan = $pickedPlan;
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
