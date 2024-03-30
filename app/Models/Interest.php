<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Interest extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public $translatable = ['name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}
