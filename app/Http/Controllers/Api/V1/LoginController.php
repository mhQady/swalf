<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\ApiBaseController;

class LoginController extends ApiBaseController
{
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->tokens()->delete();

        $token = $user->createToken('loginToken')->plainTextToken;

        return $this->respondWithSuccess(
            __('Login successfully'),
            [
                'user' => new UserResource($user),
                'token' => $token,
            ]
        );
    }
}
