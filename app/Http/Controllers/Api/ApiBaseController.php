<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ApiBaseController extends Controller
{
    protected $statusCode;

    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    protected function getStatusCode()
    {
        return $this->statusCode ?: Response::HTTP_OK;
    }

    protected function respond($resources, $headers = [])
    {
        return $resources
            ->additional(['status' => $this->getStatusCode()])
            ->response()
            ->setStatusCode($this->getStatusCode())
            ->withHeaders($headers);
    }

    protected function respondWithArray($data, $headers = [])
    {
        return response()->json($data, $data['status'], $headers);
    }

    // protected function respondWithCollection($collection, int $statusCode = null, array $headers = [])
    // {
    //     $statusCode = $statusCode ?? Response::HTTP_OK;

    //     $resources = forward_static_call([$this->modelResource, 'collection'], $collection);

    //     return $this->setStatusCode($statusCode)->respond($resources, $headers);
    // }

    // protected function respondWithModel($model, int $statusCode = null, array $headers = [])
    // {
    //     $statusCode = $statusCode ?? Response::HTTP_OK;

    //     $resource = new $this->modelResource($model);

    //     return $this->setStatusCode($statusCode)->respond($resource, $headers);
    // }

    protected function respondWithSuccess($message = 'messages.success', $data = [], $meta = false)
    {
        $response = [
            'status' => Response::HTTP_OK,
        ];

        if (!empty($message)) {
            $response['message'] = __($message);
        }

        if (!empty($data)) {
            $response['data'] = $data;
        }

        if ($meta) {
            $response['meta'] = ['page' => $data->currentPage(), 'total_pages' => $data->lastPage()];
        }

        return $this->setStatusCode(Response::HTTP_OK)->respondWithArray($response);
    }

    protected function respondWithError($message)
    {
        if ($this->statusCode === Response::HTTP_OK) {
            trigger_error(
                'You better have a really good reason for erroring on a 200...',
                E_USER_WARNING
            );
        }

        return $this->respondWithErrors($message, $this->statusCode);
    }

    protected function respondWithErrors($errors = 'messages.error', $statusCode = null, $data = [], $message = null)
    {
        $statusCode = !empty($statusCode) ? $statusCode : Response::HTTP_BAD_REQUEST;

        if (is_string($errors)) {
            $errors = __($errors);
        }

        $response = ['status' => $statusCode, 'errors' => $errors];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return $this->setStatusCode($statusCode)->respondWithArray($response);
    }

    protected function respondWithBoolean($result)
    {
        return $result ? $this->respondWithSuccess() : $this->errorUnknown();
    }

    /***
     * *******************************************************************************************
     * *******************************************************************************************
     */

    /**
     * Generates a Response with a 403 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)->respondWithError($message);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorWrongArgs($message = 'Wrong Arguments')
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorUnknown($message = 'dashboard.unknown_error')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }
}
