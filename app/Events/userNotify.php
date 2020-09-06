<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class userNotify implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $booking_id;
    private $user_id,$status;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($booking_id,$status,$user_id)
    {
        $this->booking_id = $booking_id;
        $this->status     = $status;
        $this->user_id    = $user_id;
    } 
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastAs()
    {
        switch ($this->status) {
            case 'COMPLETED':
                return 'get_completed_order';
                break;
            
            case 'DELIEVERING':
                return 'get_delievering_order';
                break;
            case 'PREPAIRING':
                return 'get_preparing_order';
                break;
            case 'CONFIRMED':
                return 'get_confirmed_order';
                break;
        }
    }
    public function broadcastOn()
    {
        return new PrivateChannel('user-'.$this->user_id);//Private
    }
}
