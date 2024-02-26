<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\InterestsResource;
use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Interest;

class InterestsController extends ApiBaseController
{
    public function __invoke()
    {
        return $this->respondWithSuccess(null, [
            'interests' => InterestsResource::collection(Interest::select(['id', 'name'])->get()),
        ]);
    }
}
