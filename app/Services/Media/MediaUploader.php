<?php

namespace App\Services\Media;

use App\Models\TempUploader;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaUploader
{
    public static function upload($files, string|null $collection = 'main', Model|null $model = null)
    {

        $model = $model ?? TempUploader::firstOrCreate();

        $uploadedFiles = [];

        if (!is_iterable($files))
            $files = [$files];


        foreach ($files as $file) {
            $uploadedFiles[] = $model->addMedia($file)->toMediaCollection($collection);
        }

        return $uploadedFiles;
    }

    public static function sync(Model $model, array $filesIds)
    {
        return Media::whereIn('id', $filesIds)->update(
            [
                'model_id' => $model->id,
                'model_type' => get_class($model)
            ]
        );
    }
}
