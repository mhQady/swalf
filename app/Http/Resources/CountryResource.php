<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CountryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_code' => $this->phone_code,
            'has_market' => $this->has_market,
            'currency_code' => $this->currency_code
        ];
    }
}
