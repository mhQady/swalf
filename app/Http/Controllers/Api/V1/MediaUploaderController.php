<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\Media\MediaSourceEnum;
use App\Http\Resources\MediaResource;
use App\Http\Controllers\Api\ApiBaseController;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaUploaderController extends ApiBaseController
{
    public function uploadFile(Request $request)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
            'source' => ['required', 'string', Rule::in(MediaSourceEnum::values())],
            'collection' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {

                    if ($request->source === MediaSourceEnum::PRODUCT->value && !in_array($value, Product::MEDIA_COLLECTIONS))
                        $fail('Collection name must be one of product files allowed collections (' . implode(',', Product::MEDIA_COLLECTIONS) . ') when the source is ' . MediaSourceEnum::PRODUCT->value);
                }
            ],
        ]);

        $files = uploadFiles($request->file('files'), $request->collection);

        return $this->respondWithSuccess(
            (__("main.uploaded.file")),
            [
                'file' => MediaResource::collection($files),
            ]
        );
    }

    public function deleteFile(Media $media)
    {
        if (!$media)
            return $this->respondWithError(__('main.not_found.file'));

        $media->delete();

        return $this->respondWithSuccess(__("main.deleted.file"));
    }
}
