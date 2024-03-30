<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Country extends Model
{
    protected $guarded = ['id'];
    public function scopeOfHasMarket(Builder $query, $hasMarket = false): void
    {
        if ((bool) $hasMarket)
            $query->where('has_market', true);
    }

    public function cities()
    {
        return $this->hasManyThrough(City::class, State::class);
    }
}
