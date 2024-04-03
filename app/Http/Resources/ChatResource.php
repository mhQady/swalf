<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->micro = [
            'id' => $this->id,
            'unread_count' => $this->unreadMessagesCount,
        ];

        $this->relations = [
            'latest_message' => new MessageResource($this->whenLoaded('latestMessage')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'other_side_members' => UserResource::collection($this->whenLoaded('otherSideMembers')),
            'members' => UserResource::collection($this->whenLoaded('members')),
            'started_by' => new UserResource($this->whenLoaded('startedBy')),
            'messages' => MessageResource::collection($this->whenLoaded('messages')),
        ];

        return $this->getResource();
    }
}
