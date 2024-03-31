<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;
use App\Http\Resources\InterestResource;
use App\Http\Controllers\Api\ApiBaseController;

class HomeController extends ApiBaseController
{

    public function search(Request $request)
    {
        $products = Product::filter()->latest()->with('mainImg')->with('city');

        return $this->respondWithSuccess(null, [
            'results_count' => $products->count(),
            'products' => ProductResource::collection($products->skip(request('skip', 0))->take(10)->get()),
        ]);
    }
    public function getSuggestedProducts()
    {
        return $this->respondWithSuccess(null, [
            'products' => ProductResource::collection(
                auth()->user()->suggestedProducts()->skip(request('skip', 0))->take(10)->get()
            ),
        ]);
    }

    public function getUserInterests()
    {
        return $this->respondWithSuccess(null, [
            'interests' => InterestResource::collection(
                auth()->user()->interests()->select(['id', 'name'])
                    ->withCount('products')
                    ->orderBy('products_count', 'desc')->get()
            ),
        ]);
    }
}
