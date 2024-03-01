<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
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
            'country_id' => ['required', 'exists:countries,id'],
        ]);

        $request->user()->update($validated);

        return $this->respondWithSuccess(__('main.updated.profile'), [
            'user' => new UserResource($request->user()->fresh()->load('country'))
        ]);
    }

    public function delete()
    {
        auth()->user()->delete();

        return $this->respondWithSuccess(__('main.deleted.user'));
    }
}
