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
            'price' => $this->price,
            'old_price' => $this->old_price,
            'created_at' => $this->created_at,
        ];

        $this->mini = [
            'description' => $this->description,
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
            'interest_id' => $this->interest_id,
            'is_published' => $this->is_published,
        ];

        $this->relations = [
            'main_img' => new MediaResource($this->whenLoaded('mainImg')),
            'city' => new CityResource($this->whenLoaded('city')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
        ];

        return $this->getResource();
    }
}
