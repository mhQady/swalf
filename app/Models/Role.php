<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role as SpatieRole;


class Role extends SpatieRole
{
    public function scopeFilter(Builder $query): void
    {
        $query->when(request('q'), fn($query) => $query->where('name', 'like', '%' . request('q') . '%'));
    }
}
