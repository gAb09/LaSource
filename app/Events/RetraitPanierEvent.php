<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RetraitPanierEvent extends Event
{
    use SerializesModels;


    public $panier_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($panier_id)
    {
        $this->panier_id = $panier_id;
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
