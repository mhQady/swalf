<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class MediaResource extends BaseResource
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
            'name' => $this->name,
            'file_name' => $this->file_name,
            'full_url' => $this->getFullUrl(),
        ];


        return $this->getResource();
    }
}
