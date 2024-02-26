<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Interest extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public $translatable = ['name'];

}
