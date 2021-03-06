<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessagePosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    protected $message;

    public function __construct($message)
    {        
        $this->message = $message;
    }

    public function broadcastWith()
    {        
        return [            
            'message' => $this->message,
        ];
    }

    public function broadcastAs()
    {
        return 'newMessage';
    }

    public function broadcastOn()
    {
        return new Channel('messages');
    }
}