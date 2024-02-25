<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Services\OTP\OtpSender;
use App\Services\OTP\OTPVerifier;
use Illuminate\Http\JsonResponse;
use App\Enums\User\CompleteDataEnum;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\ApiBaseController;
use App\Http\Requests\Api\Auth\EnterPhoneRequest;
use App\Http\Requests\Api\Auth\VerifyPhoneRequest;
use App\Http\Requests\Api\Auth\EnterPasswordRequest;

class RegisterController extends ApiBaseController
{
    # 1. Send OTP to user phone
    public function enterPhone(EnterPhoneRequest $request): JsonResponse
    {
        $user = User::firstOrCreate(
            ['phone' => $request->phone],
            ['phone_code' => $request->phone_code]
        );

        if ($user->phone_verified_at)
            return $this->respondWithErrors(__('main.verified.phone'), 409, ['step' => $user->nextStep(), 'user' => new UserResource($user)]);

        OtpSender::send($user, 2, __('main.confirm.phone'));

        return $this->respondWithSuccess(
            __('main.sent.otp'),
            ['user' => new UserResource($user)]
        );
    }

    # 2. Verify phone number
    public function verifyPhone(VerifyPhoneRequest $request): JsonResponse
    {
        $user = User::find($request->user_id);

        if (!$user)
            return $this->respondWithErrors(__('main.not_found.user'), 404);

        if ($user->complete_data != CompleteDataEnum::NONE)
            return $this->respondWithErrors(__('main.wrong_step'), 409, ['step' => $user->nextStep(), 'user' => new UserResource($user)]);

        if (!OTPVerifier::verify($user, $request->code))
            return $this->respondWithErrors(__('Otp is expired or invalid.'));

        $user->complete_data = CompleteDataEnum::PHONE_VERIFIED->value;
        $user->forceFill(['phone_verified_at' => now()]);
        $user->save();

        return $this->respondWithSuccess(__('main.verified.phone'), ['user' => new UserResource($user)]);
    }

    # 3. Enter Password
    public function enterPassword(EnterPasswordRequest $request): JsonResponse
    {
        $user = User::find($request->user_id);

        if ($user->password)
            return $this->respondWithErrors(__('main.password_entered'), 409, ['step' => $user->nextStep(), 'user' => new UserResource($user)]);

        $user->update([
            'complete_data' => CompleteDataEnum::PASSWORD_ENTERED->value,
            'password' => $request->password
        ]);

        return $this->respondWithSuccess(
            __('Password has been saved successfully'),
            [
                'user' => new UserResource($user->fresh()),
                'token' => $user->createToken('login-token')->plainTextToken
            ]
        );
    }
}
