<?php

namespace App\Events;

use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Message;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    protected $chatId;
    public $message;
    public $sender;

    public function __construct(Message $message, User|Authenticatable $sender)
    {
        $this->chatId = $message->chat_id;
        $this->message = new MessageResource($message);
        $this->sender = new UserResource($sender);
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('chat.1'),
        ];
    }
}
