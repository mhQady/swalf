<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\Api\ApiBaseController;

class ProductController extends ApiBaseController
{
    public function index()
    {
        return $this->respondWithSuccess(null, [
            'products' => ProductResource::collection(auth()->user()->products()->with(['mainImg', 'city', 'interest'])->latest()->get()),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $user = auth()->user();

        $data = array_merge(
            [
                'user_id' => $user->id,
                'country_id' => $user->country_id
            ],
            $request->validated()
        );

        try {
            DB::beginTransaction();

            $product = Product::create($data);

            if ($request->files_ids)
                syncFiles($product, $request->files_ids);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondWithError($e->getMessage());
        }


        return $this->respondWithSuccess(__('main.created.product'), [
            'product' => new ProductResource($product),
        ]);
    }

    public function show(Product $product)
    {
        return $this->respondWithSuccess(null, [
            'product' => new ProductResource($product->load('media', 'interest', 'city', 'country', 'owner')),
            'similarities' => $product->user_id == auth()->id() ? [] : ProductResource::collection($product->similarities())
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            $product->update($request->validated());

            if (isset($request->files_ids))
                syncFiles($product, $request->files_ids);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondWithError($e->getMessage());
        }

        return $this->respondWithSuccess(__('main.updated.product'), [
            'product' => new ProductResource($product->with(['mainImg', 'city', 'interest'])->fresh()),
        ]);
    }

    public function destroy(Product $product)
    {
        if ($product && $product->user_id != auth()->id())
            return $this->respondWithError(__('main.not_owner.product'));

        $product->delete();

        return $this->respondWithSuccess(__('main.deleted.product'));
    }
}
