<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Enums\Chat\MessageTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const MEDIA_COLLECTIONS = ['main'];
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'type' => MessageTypeEnum::class
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
    public function registerMediaCollections(): void
    {
        foreach (self::MEDIA_COLLECTIONS as $collection) {
            $this->addMediaCollection($collection);
        }
    }
}
