<?php

namespace App\Models;

use App\Enums\PublishStatusEnum;
use App\Enums\User\GenderEnum;
use App\Enums\User\StatusEnum;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use App\Enums\User\CompleteDataEnum;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    const MEDIA_COLLECTIONS = ['profile'];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'complete_data' => CompleteDataEnum::class,
        'gender' => GenderEnum::class,
        'status' => StatusEnum::class,
        'phone_verified_at' => 'datetime',
        'change_password_requested_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class);
    }
    public function allOtp()
    {
        return $this->morphMany(Otp::class, 'otpable');
    }

    public function lastOtp()
    {
        return $this->morphOne(Otp::class, 'otpable')->latestOfMany();
    }

    public function market(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_member', 'user_id', 'chat_id');
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function nextStep()
    {
        return match ($this->complete_data) {
            CompleteDataEnum::NONE => CompleteDataEnum::PHONE_VERIFIED,
            CompleteDataEnum::PHONE_VERIFIED => CompleteDataEnum::PASSWORD_ENTERED,
            CompleteDataEnum::PASSWORD_ENTERED => CompleteDataEnum::PERSONAL_INFO_ENTERED,
            CompleteDataEnum::PERSONAL_INFO_ENTERED => CompleteDataEnum::COUNTRY_ENTERED,
            CompleteDataEnum::COUNTRY_ENTERED => CompleteDataEnum::INTERESTS_ENTERED,
            default => CompleteDataEnum::NONE,
        };
    }

    public function suggestedProducts()
    {
        return Product::where('is_published', PublishStatusEnum::PUBLISHED->value)
            ->where('user_id', '!=', $this->id)
            ->whereIn('interest_id', $this->interests()->pluck('id'))
            ->with('mainImg')
            ->with('city')
            ->latest();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(50)
                    ->height(50);
            });
    }

    protected function profileImgThumbUrl(): Attribute
    {
        return new Attribute(get: fn($value): string => $this->getFirstMediaUrl('profile', 'thumb'));
    }
    protected function profileImgUrl(): Attribute
    {
        return new Attribute(get: fn($value): string => $this->getFirstMediaUrl('profile'));
    }
    protected function fullPhone(): Attribute
    {
        return new Attribute(get: fn($value): string => $this->phone_code . $this->phone);
    }
    protected function isBanned(): Attribute
    {
        return new Attribute(get: fn($value): bool => $this->status === StatusEnum::BANNED);
    }

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('q'), function ($query) {
            $query->where('name', 'like', '%' . request('q') . '%')
                ->orWhere('email', 'like', '%' . request('q') . '%');
        });

        // $query->when(request('interests'), function ($query) {

        //     $interests = explode(',', request('interests'));

        //     if (count($interests) > 1) {
        //         $query->whereIn('interest_id', $interests);
        //         return;
        //     }

        //     $query->where('interest_id', request('interests'));
        // });

        // $query->when(request('cities'), function ($query) {

        //     $cities = explode(',', request('cities'));

        //     if (count($cities) > 1) {
        //         $query->whereIn('city_id', $cities);
        //         return;
        //     }

        //     $query->where('city_id', request('cities'));
        // });

        // $query->when(request('user'), fn($query) => $query->where('user_id', request('user')));
    }

}
