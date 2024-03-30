<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    const MEDIA_COLLECTIONS = ['main'];

    protected $guarded = ['id'];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'float',
        'old_price' => 'float',
    ];


    public function mainImg(): MorphOne
    {
        return $this->morphOne(config('media-library.media_model'), 'model')->oldestOfMany();
    }
    public function registerMediaCollections(): void
    {
        foreach (self::MEDIA_COLLECTIONS as $collection) {
            $this->addMediaCollection($collection);
        }
    }
}
