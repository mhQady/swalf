<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use App\Http\Resources\UserResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\MessageResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $message;

    public function __construct(Message $message, protected Chat $chat)
    {
        $this->message = new MessageResource($message->load('sender'));
    }

    public function broadcastOn(): array
    {
        return $this->chat->members()
            ->select('users.id')->where('users.id', '!=', $this->message->sender_id)->pluck('users.id')
            ->map(fn($id) => new Channel("chats.{$id}"))->toArray();

    }
}
