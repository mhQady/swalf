<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends ApiBaseController
{
    public function login(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'driver' => 'required|string|in:google,apple',
        ]);
        try {
            $socialUser = Socialite::driver($request->driver)->stateless()->userFromToken($request->token);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response(['message' => $e->getMessage()], 500);
        }

        $user = User::firstOrCreate(
            ['email' => $socialUser->email],
            [
                'name' => $socialUser->name,
                'password' => 'password',
                'phone' => 1,
                'phone_verified_at' => now(),
            ]
        );

        $user->tokens()->delete();

        $token = $user->createToken('login-token')->plainTextToken;

        return $this->respondWithSuccess(
            __('Login successfully'),
            [
                'user' => new UserResource($user),
                'token' => $token,
                'socialUser' => $socialUser,
            ]
        );
        // Getting or creating user from db
        // $userFromDb = User::firstOrCreate(
        //     ['email' => $user->getEmail()],
        //     [
        //         'email_verified_at' => now(),
        //         'first_name' => $user->offsetGet('given_name'),
        //         'last_name' => $user->offsetGet('family_name'),
        //         'avatar' => $user->getAvatar(),
        //     ]
        // );

        // // Returning response
        // $token = $userFromDb->createToken('Laravel Sanctum Client')->plainTextToken;
        // $response = ['token' => $token, 'message' => 'Google Login/Signup Successful'];
        // return response([$response, $user], 200);
    }
}
