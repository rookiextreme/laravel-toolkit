<?php
declare(strict_types=1);

namespace Tests\Response;

use Illuminate\Http\JsonResponse;
use Orchestra\Testbench\TestCase;
use Rookiextreme\LaravelToolkit\Response\ApiResponse;

class ApiResponseTest extends TestCase
{
    public function test_message_payload()
    {
        $apiResponse = new ApiResponse();

        $this->assertArrayHasKey(
            'message',
            $apiResponse->buildMessagePayload('success', 'Some message')
        );
    }

    public function test_message_payload_not_string()
    {
        $apiResponse = new ApiResponse();

        $this->expectException(\TypeError::class);

        $apiResponse->buildMessagePayload(1, true);
    }

    public function test_data_payload()
    {
        $apiResponse = new ApiResponse();

        $this->assertArrayHasKey(
            'data',
            $apiResponse->buildDataPayload('success', [
                'key' => 'value'
            ])
        );
    }

    public function test_data_payload_not_string()
    {
        $apiResponse = new ApiResponse();

        $this->expectException(\TypeError::class);

        $apiResponse->buildDataPayload(1, 5);
    }

    public function test_message_response()
    {
        $apiResponse = new ApiResponse();

        $this->assertInstanceOf(
            JsonResponse::class,
            $apiResponse->jsonResponse($apiResponse->buildMessagePayload('success', 'Some message'))
        );
    }

    public function test_data_response()
    {
        $apiResponse = new ApiResponse();

        $this->assertInstanceOf(
            JsonResponse::class,
            $apiResponse->jsonResponse($apiResponse->buildDataPayload('success', [
                'key' => 'value'
            ]))
        );
    }

    public function test_response_payload_error()
    {
        $apiResponse = new ApiResponse();

        $this->expectException(\TypeError::class);

        $apiResponse->jsonResponse('this is just a string');
    }
}