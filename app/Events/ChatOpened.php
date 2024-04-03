<?php

namespace App\Events;

use App\Models\Chat;
use App\Http\Resources\UserResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatOpened
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $chat_id;
    public $user;
    public function __construct(protected Chat $chat)
    {
        $this->chat_id = $chat->id;
        $this->user = new UserResource(auth()->user());
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return $this->chat->otherSideMembers()
            ->select('users.id')->pluck('users.id')
            ->map(fn($id) => new Channel("chats.{$id}"))->toArray();
    }
}
