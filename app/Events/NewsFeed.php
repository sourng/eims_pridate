<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewsFeed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $feed;
    public $event;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($feed , $event = 'my-event')
    {
        $this->feed = $feed;
        $this->event = $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['feed-channel'];
    }

    public function broadcastAs()
    {
        return $this->event;
    }
}
