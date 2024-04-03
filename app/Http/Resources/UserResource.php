<?php

namespace App\Http\Resources;

use App\Http\Resources\AddressResource;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->micro = [
            'id' => $this->id,
            'complete_data_status' => $this->complete_data,
            'name' => $this->name,
            'phone_code' => $this->phone_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'profile_thumb' => $this->profileImgThumbUrl,
            'profile_img' => $this->profileImgUrl,
            // 'market_id' => $this->country_id,
        ];

        $this->mini = [

        ];

        $this->full = [

        ];

        $this->relations = [
            'tokens' => $this->whenLoaded('tokens'),
            'market' => new CountryResource($this->whenLoaded('market')),
        ];

        return $this->getResource();
    }
}
