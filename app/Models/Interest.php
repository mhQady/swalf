<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Interest extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;
    const MEDIA_COLLECTIONS = ['main'];

    protected $guarded = ['id'];
    public $translatable = ['name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('q'), fn($query) => $query->where('name->ar', 'like', '%' . request('q') . '%')->orWhere('name->en', 'like', '%' . request('q') . '%'));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100);
            });
    }

    protected function mainImgThumbUrl(): Attribute
    {
        return new Attribute(get: fn($value): string => $this->getFirstMediaUrl('main', 'thumb'));
    }
    protected function mainImgUrl(): Attribute
    {
        return new Attribute(get: fn($value): string => $this->getFirstMediaUrl('main'));
    }
}
