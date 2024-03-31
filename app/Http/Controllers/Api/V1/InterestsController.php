<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\InterestResource;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Interest;

class InterestsController extends ApiBaseController
{
    public function index()
    {
        return $this->respondWithSuccess(null, [
            'interests' => InterestResource::collection(Interest::select(['id', 'name'])
                ->whereHas('products')
                ->withCount('products')
                ->orderBy('products_count', 'desc')
                ->get()),
        ]);
    }
}
