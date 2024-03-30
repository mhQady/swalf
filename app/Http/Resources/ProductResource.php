<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ProductResource extends BaseResource
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
            'description' => $this->description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
            'interest_id' => $this->interest_id,
            'is_published' => $this->is_published,
            'created_at' => $this->created_at,
        ];

        $this->relations = [
            'main_img' => new MediaResource($this->whenLoaded('mainImg')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
        ];

        return $this->getResource();
    }
}
