<?php

namespace App\Models;

use App\Models\Scopes\MarketScope;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([MarketScope::class])]
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

    public function interest()
    {
        return $this->belongsTo(Interest::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
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

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%');
        });

        $query->when(request('interests'), function ($query) {

            $interests = explode(',', request('interests'));

            if (count($interests) > 1) {
                $query->whereIn('interest_id', $interests);
                return;
            }

            $query->where('interest_id', request('interests'));
        });

        $query->when(request('cities'), function ($query) {

            $cities = explode(',', request('cities'));

            if (count($cities) > 1) {
                $query->whereIn('city_id', $cities);
                return;
            }

            $query->where('city_id', request('cities'));
        });

        $query->when(request('user'), fn($query) => $query->where('user_id', request('user')));
    }
}
