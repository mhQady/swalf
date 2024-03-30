<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\InterestResource;
use App\Http\Controllers\Api\ApiBaseController;

class HomeController extends ApiBaseController
{
    public function index()
    {
        $user = auth()->user();
        return $this->respondWithSuccess(null, [
            'interests' => $user->recommendedInterests()->get()
        ]);
    }
}
