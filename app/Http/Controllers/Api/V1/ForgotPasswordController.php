<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\OTP\OtpSender;
use App\Services\OTP\OTPVerifier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Api\ApiBaseController;

class ForgotPasswordController extends ApiBaseController
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'numeric', 'regex:/^[0-9]{4,12}$/', 'exists:users,phone']
        ]);

        OtpSender::send(User::where('phone', $request->phone)->firstOrFail(), 2);

        return $this->respondWithSuccess(__('main.sent.otp'));
    }

    public function confirmOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'numeric', 'regex:/^[0-9]{4,12}$/', 'exists:users,phone'],
            'code' => ['required', 'numeric', 'exists:otps,code']
        ]);

        $user = User::where('phone', $request->phone)->firstOrFail();

        if (!OTPVerifier::verify($user, $request->code))
            return $this->respondWithErrors(__('main.not_valid.otp'));

        $user->update(['change_password_requested_at' => now()]);

        return $this->respondWithSuccess(__('main.verified.otp'));
    }

    public function changePassword(Request $request)
    {
        $user = User::where('phone', $request->phone)->select('id', 'password', 'change_password_requested_at')->first();

        if (!$user || !$user->change_password_requested_at)
            return $this->respondWithErrors(__('main.not_change_password_request'));

        $request->validate([
            'phone' => ['required', 'numeric', 'regex:/^[0-9]{4,12}$/', 'exists:users,phone'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
                function (string $attribute, mixed $value, \Closure $fail) use ($user) {
                    if (Hash::check($value, $user->password))
                        $fail(__('passwords.not_match_current'));
                },
                function (string $attribute, mixed $value, \Closure $fail) use ($user) {
                    if (now()->diffInMinutes(Carbon::parse($user->change_password_requested_at)) >= config('system.CHANGE_PASSWORD_EXPIRY'))
                        $fail(__('main.not_valid.change_password_request'));
                }
            ],
        ]);

        $user->update([
            'password' => $request->password,
            'change_password_requested_at' => null
        ]);

        return $this->respondWithSuccess(__('main.changed.password'));
    }
}
