<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Enums\Chat\MessageTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'type' => MessageTypeEnum::class,
        'read_by' => 'array',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->read_by = [];
        });
    }

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

    protected function isRead(): Attribute
    {
        return new Attribute(
            get: fn($value): bool => count($this->read_by ?? []) >= $this->chat->otherSideMembers()->count()
        );
    }
}
