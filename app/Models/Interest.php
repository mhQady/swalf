<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interest extends Model
{
    use HasTranslations;

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
}
