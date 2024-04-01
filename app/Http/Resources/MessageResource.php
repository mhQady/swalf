<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends BaseResource
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
            'chat_id' => $this->chat_id,
            'message' => $this->message,
            'sender_id' => $this->sender_id,
            'created_at' => $this->created_at
        ];

        $this->relations = [
            'sender' => new UserResource($this->whenLoaded('sender')),
        ];

        return $this->getResource();
    }
}
