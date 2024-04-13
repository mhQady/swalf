<?php

namespace App\Models;

use App\Enums\Country\HasMarketEnum;
use App\Enums\Country\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'is_active' => StatusEnum::class,
        'has_market' => HasMarketEnum::class,
    ];
    public function scopeOfHasMarket(Builder $query, $hasMarket = false): void
    {
        if ((bool) $hasMarket)
            $query->where('has_market', true);
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
    public function cities(): HasManyThrough
    {
        return $this->hasManyThrough(City::class, State::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('q'), function ($query) {
            $query->where('name', 'like', '%' . request('q') . '%')
                ->orWhere('code', 'like', '%' . request('q') . '%')
                ->orWhere('phone_code', 'like', '%' . request('q') . '%');
        });
    }
}
