<?php

namespace Hikingyo\Ovh\Tests\HttpClient;

use GuzzleHttp\Psr7\Response;
use Hikingyo\Ovh\HttpClient\ApiResponse;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ApiResponseTest extends TestCase
{
    public function testGetResponse(): void
    {
        $payload = ['123456', '234567'];
        $httpResponse = new Response(200, ['Content-Type' => 'application/json'], json_encode($payload));
        $response = new ApiResponse($httpResponse);
        $this->assertEquals(200, $response->getResponse()->getStatusCode());
        $this->assertEquals($payload, json_decode($response->getResponse()->getBody()->getContents()));
    }

    public function testGetReasonPhrase(): void
    {
        $payload = ['123456', '234567'];
        $httpResponse = new Response(200, ['Content-Type' => 'application/json'], json_encode($payload));
        $response = new ApiResponse($httpResponse);
        $this->assertEquals('OK', $response->getReasonPhrase());
    }

    public function testGetStatusCode(): void
    {
        $payload = ['123456', '234567'];
        $httpResponse = new Response(200, ['Content-Type' => 'application/json'], json_encode($payload));
        $response = new ApiResponse($httpResponse);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetContent(): void
    {
        $payload = ['123456', '234567'];
        $httpResponse = new Response(200, ['Content-Type' => 'application/json'], json_encode($payload));
        $response = new ApiResponse($httpResponse);
        $this->assertEquals($payload, $response->getContent());
    }

    public function testGetErrorMessage(): void
    {
        $payload = ['error' => 'Invalid API key'];
        $httpResponse = new Response(401, ['Content-Type' => 'application/json'], json_encode($payload));
        $response = new ApiResponse($httpResponse);
        $this->assertEquals('Invalid API key', $response->getErrorMessage());

        $payload = ['message' => ['123456', 'reason' => ['"1" 2', '"3" 4'], 'cause' => 'unknown']];
        $httpResponse = new Response(402, ['Content-Type' => 'application/json'], json_encode($payload));
        $response = new ApiResponse($httpResponse);
        $this->assertEquals('123456, "reason" "1" 2, "reason" "3" 4, "cause" unknown', $response->getErrorMessage());

        $payload = ['message' => "You don't have the permission to access this resource"];
        $httpResponse = new Response(403, ['Content-Type' => 'application/json'], json_encode($payload));
        $response = new ApiResponse($httpResponse);
        $this->assertEquals("You don't have the permission to access this resource", $response->getErrorMessage());

        $payload = ['error_description' => "You don't have the permission to access this resource"];
        $httpResponse = new Response(403, ['Content-Type' => 'application/json'], json_encode($payload));
        $response = new ApiResponse($httpResponse);
        $this->assertEquals("You don't have the permission to access this resource", $response->getErrorMessage());
    }
}
