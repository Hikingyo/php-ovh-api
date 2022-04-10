<?php

namespace Hikingyo\Ovh\Tests\HttpClient\Plugin;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Hikingyo\Ovh\Client;
use Hikingyo\Ovh\Exception\ResourceNotFoundException;
use Hikingyo\Ovh\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ExceptionThrowerTest extends TestCase
{
    public function testWhenResponseReturnHttpCode404ResourceNotFoundExceptionIsThrown()
    {
        $mock = new MockHandler([
            new Response(404, []),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new HttpClient(['handler' => $handlerStack]);
        $client = Client::createWithHttpClient($httpClient, 'ovh-eu');

        $this->expectException(ResourceNotFoundException::class);
        $this->expectExceptionMessage('Not Found');

        $client->auth()->time();
    }

    public function testWhenResponseReturnErrorHttpCodeOtherThan404RuntimeExceptionIsThrown()
    {
        $mock = new MockHandler([
            new Response(418, []),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new HttpClient(['handler' => $handlerStack]);
        $client = Client::createWithHttpClient($httpClient, 'ovh-eu');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("I'm a teapot");

        $client->auth()->time();
    }
}
