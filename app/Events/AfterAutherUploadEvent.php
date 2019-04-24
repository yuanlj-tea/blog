<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterAutherUploadEvent extends Event
{
    use SerializesModels;

    public $receiver;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
