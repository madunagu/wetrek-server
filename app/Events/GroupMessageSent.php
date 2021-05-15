<?php

namespace App\Events;

use App\Trek;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupMessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Trek $trek;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Trek $trek)
    {
        $this->trek = $trek;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('Messages.Group.' . $this->trek->id);
    }
}
