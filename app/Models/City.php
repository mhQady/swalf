<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    public function country(): BelongsTo
    {
        return $this->state->country();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function scopeFilter(Builder $query): void
    {
        $query->when(request('q'), function ($query) {
            $query->where('name', 'like', '%' . request('q') . '%')
                ->orWhereHas('state', function ($q) {
                    $q->whereHas('country', function ($q) {
                        $q->where('name', 'like', '%' . request('q') . '%');
                    });
                });
        });
    }

}
