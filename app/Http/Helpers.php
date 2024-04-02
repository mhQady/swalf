<?php

use App\Services\Media\MediaUploader;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('uploadFiles')) {
    function uploadFiles($files, string|null $collection = 'main', Model|null $model = null)
    {
        return MediaUploader::upload($files, $collection, $model);
    }
}

if (!function_exists('syncFiles')) {
    function syncFiles(Model $model, array $filesIds)
    {
        return MediaUploader::sync($model, $filesIds);
    }
}
