<?php
namespace Rookiextreme\LaravelToolkit\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ApiResponse
{
    public function buildMessagePayload(string $status, string $message = '') : array
    {
        return [
            'status' => $status,
            'message' => $message
        ];
    }

    public function buildDataPayload(string $status, array $data = []) : array
    {
        return [
            'status' => $status,
            'data' => $data
        ];
    }

    public function jsonResponse(array $payload) : JsonResponse{
        $load = [
            'status' => $payload['status'],
        ];

        if(array_key_exists('data', $payload))
        {
            $load['data'] = $payload['data'];
        }else{
            $load['message'] = $payload['message'];
        }

        return Response::json($load, $this->getStatusCode($payload['status']));
    }

    public function getStatusCode($status) : int{
        return $status == 'success' ? 200 : 401;
    }
}