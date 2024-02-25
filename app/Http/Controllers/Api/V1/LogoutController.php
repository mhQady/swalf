<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends ApiBaseController
{
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respondWithSuccess(__('main.logged_out'));
    }
}
