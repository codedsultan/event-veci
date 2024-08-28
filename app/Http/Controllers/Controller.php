<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller as BaseController;
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function respondWithData($data = null, $message = null, $status = 'success', $statusCode = 200): JsonResponse
    {
        $payload = [
            'meta' => [
                'status' => $status,
                'message' => $message,
            ],
        ];

        if ($data !== null) {

            if ($data instanceof AnonymousResourceCollection) {
                return $data->additional($payload)->response()->setStatusCode($statusCode);
            }

            $payload['data'] = $data;
        }

        return response()->json($payload, $statusCode)->withHeaders([
            'X-API-Version' => 'v1.0',
            'X-Powered-By' => 'Event X',
        ]);
    }

    public function respondWithSuccess($message = null, $data = null, $statusCode = 200): JsonResponse
    {
        return $this->respondWithData($data, $message, 'success', $statusCode);
    }
}
