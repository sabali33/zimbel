<?php

namespace App\Events;

use App\License;
use App\Customer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CustomerRegisteredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $license;
    public $customer;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( Customer $customer, License $license)
    {
        $this->customer = $customer;
        $this->license = $license;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
