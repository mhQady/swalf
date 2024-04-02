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
        ];

        $this->relations = [
            'latest_message' => new MessageResource($this->whenLoaded('latestMessage')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'started_by' => new UserResource($this->whenLoaded('startedBy')),
            'messages' => MessageResource::collection($this->whenLoaded('messages')),
            'members' => UserResource::collection($this->whenLoaded('members')),
        ];

        return $this->getResource();
    }
}
