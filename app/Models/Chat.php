<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['product_id', 'started_by'];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->latest()->skip(request('messages_skip', 0))->take(10);
    }
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'chat_member', 'chat_id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function startedBy()
    {
        return $this->belongsTo(User::class, 'started_by');
    }

}
