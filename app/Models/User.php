<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\User\CompleteDataEnum;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
}
