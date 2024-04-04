<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Report;
use App\Models\ReportType;
use App\Http\Requests\Api\ReportRequest;
use App\Http\Resources\ReportTypeResource;
use App\Http\Controllers\Api\ApiBaseController;

class ReportController extends ApiBaseController
{
    public function getReportTypes()
    {
        return $this->respondWithSuccess(null, [
            'types' => ReportTypeResource::collection(ReportType::all())
        ]);
    }

    public function send(ReportRequest $request)
    {
        Report::create($request->validated());

        return $this->respondWithSuccess(__('main.sent.report'));
    }
}
