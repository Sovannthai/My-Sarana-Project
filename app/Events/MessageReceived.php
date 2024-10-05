<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat; // Store the chat data

    public function __construct($chat)
    {
        $this->chat = $chat; // Initialize the chat data
    }

    public function broadcastOn()
    {
        return new Channel('chats'); // Broadcast on the 'messages' channel
    }
}

