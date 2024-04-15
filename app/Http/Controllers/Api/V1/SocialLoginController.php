<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return Auth::user();
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? 5555555555,
                    'google_id' => $user->id,
                    'password' => 'password'
                ]);

                Auth::login($newUser);
                return $newUser;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
