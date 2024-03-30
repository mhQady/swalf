<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TempUploader extends Model implements HasMedia
{
    protected $table = 'temp_uploader';

    use InteractsWithMedia;
}
