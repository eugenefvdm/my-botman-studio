<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageWasReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chatMessage)
    {
        $this->chatMessage = $chatMessage;
        ray("In broadcast");
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat-room.1');
        // return [
        //     "chat-room.1"
        // ];
        // return new PrivateChannel('channel-name');
    }
}

// class ChatMessageWasReceived extends Event implements ShouldBroadcast
// {
//     use InteractsWithSockets, SerializesModels;

//     public $chatMessage;
//     public $user;

//     public function __construct($chatMessage, $user)
//     {
//         $this->chatMessage = $chatMessage;
//         $this->user = $user;
//     }

//     public function broadcastOn()
//     {
//         return [
//             "chat-room.1"
//         ];
//     }
// }
