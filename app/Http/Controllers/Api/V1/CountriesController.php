<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;
use App\Http\Controllers\Api\ApiBaseController;

class CountriesController extends ApiBaseController
{
    public function index()
    {
        return $this->respondWithSuccess(null, [
            'countries' => CountryResource::collection(Country::select(['id', 'name', 'phone_code', 'has_market', 'currency_code'])
                ->ofHasMarket(request('only_markets'))->get()),
        ]);
    }
    public function getCities(Country $country)
    {
        return $this->respondWithSuccess(null, [
            'cities' => CityResource::collection($country->cities),
        ]);
    }
}
