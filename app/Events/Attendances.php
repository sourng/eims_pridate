<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Attendances implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $attendances;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['attendance-channel'];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
