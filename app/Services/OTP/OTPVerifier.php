<?php

namespace App\Services\OTP;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;


class OTPVerifier
{
    protected OTP|null $otp;
    public function __construct(protected User|Authenticatable $user, protected int $code)
    {

    }
    public static function verify(User|Authenticatable $user, int $code): bool
    {
        return (new self($user, $code))->verifyOtp();
    }

    protected function verifyOtp(): bool
    {
        $this->otp = Otp::where('code', $this->code)
            ->where('status', Otp::PENDING)
            ->where('otpable_id', $this->user->id)
            ->where('otpable_type', ($this->user)::class)
            ->where('created_at', '>=', Carbon::now()->subMinutes(config('system.OTP_EXPIRY')))
            ->first();

        if ($this->otp)
            $this->markAsVerified();

        return (bool) $this->otp && ($this->user->lastOtp->code == $this->code);
    }

    protected function markAsVerified()
    {
        $this->otp->update(['status' => OTP::VERIFIED]);
    }
}
