<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\ApiBaseController;

class ProfileController extends ApiBaseController
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'birth_date' => ['required', 'date'],
            'profile_img' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $user = $request->user();

        try {
            DB::beginTransaction();


            $user->update($validated);

            if ($request->file('profile_img'))
                uploadFiles($request->file('profile_img'), 'profile', $user);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondWithError($e->getMessage());
        }


        return $this->respondWithSuccess(__('main.updated.profile'), [
            'user' => new UserResource($user->fresh()->load('market'))
        ]);
    }

    public function delete()
    {
        auth()->user()->delete();

        return $this->respondWithSuccess(__('main.deleted.user'));
    }
}
