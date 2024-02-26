<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountriesResource;
use App\Http\Controllers\Api\ApiBaseController;

class CountriesController extends ApiBaseController
{
    public function __invoke()
    {
        return $this->respondWithSuccess(null, [
            'countries' => CountriesResource::collection(Country::select(['id', 'name'])->get()),
        ]);
    }
}
