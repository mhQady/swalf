<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function scopeNotSuperAdmin(Builder $query): void
    {
        $query->where('id', '!=', 1)->orWhere('name', '!=', 'Super Admin');
    }
    public function scopeFilter(Builder $query): void
    {
        $query->when(request('q'), function ($query) {
            $query->where('name', 'like', '%' . request('q') . '%')
                ->orWhere('email', 'like', '%' . request('q') . '%');
        });
    }
}
