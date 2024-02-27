<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\User\CompleteDataEnum;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\ApiBaseController;
use App\Http\Requests\Api\Auth\EnterPersonalInfoRequest;

class CompleteDataController extends ApiBaseController
{
    # 4. Enter personal info
    public function enterPersonalInfo(EnterPersonalInfoRequest $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->name || $user->gender || $user->birth_date)
            return $this->respondWithErrors(__('main.Personal info already entered'), 409, ['step' => $user->nextStep(), 'user' => new UserResource($user)]);

        $user->update(
            array_merge(
                $request->validated(),
                [
                    'complete_data' => CompleteDataEnum::PERSONAL_INFO_ENTERED->value,
                ]
            )
        );

        return $this->respondWithSuccess(__('main.Personal info has been saved successfully'), [
            'user' => new UserResource($user->fresh()),
        ]);
    }

    # 5. Enter country
    public function enterCountry(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->country_id)
            return $this->respondWithErrors(__('main.wrong_step'), 409, ['step' => $user->nextStep(), 'user' => new UserResource($user)]);

        $request->validate([
            'country_id' => ['required', 'exists:countries,id'],
        ]);


        $user->update(
            array_merge(
                ['country_id' => $request->country_id],
                ['complete_data' => CompleteDataEnum::COUNTRY_ENTERED->value]
            )
        );

        return $this->respondWithSuccess(__('main.country_entered'), ['user' => new UserResource($user->fresh())]);
    }

    # 6. Enter Interests
    public function enterInterests(Request $request): JsonResponse
    {
        $request->validate([
            'interests' => ['required', 'array'],
            'interests.*' => ['integer', 'exists:interests,id']
        ]);

        $user = Auth::user();

        if ($user->interests()->exists())
            return $this->respondWithErrors(__('main.wrong_step'), 409, ['step' => $user->nextStep(), 'user' => new UserResource($user)]);

        try {

            DB::transaction(function () use ($request, $user) {

                $user->update([
                    'complete_data' => CompleteDataEnum::INTERESTS_ENTERED->value,
                ]);

                $user->interests()->attach($request->interests);
            });

        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
        }

        return $this->respondWithSuccess(
            __('main.interests_entered'),
            [
                'user' => new UserResource($user->fresh()),
            ]
        );
    }
}
