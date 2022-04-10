<?php

namespace Hikingyo\Ovh\Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Hikingyo\Ovh\Client;
use Hikingyo\Ovh\Exception\InvalidParameterException;
use Hikingyo\Ovh\HttpClient\HttpClientFactory;
use Http\Client\Common\HttpMethodsClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ClientTest extends TestCase
{
    public function testCreateClient(): void
    {
        $client = new Client();
        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(HttpMethodsClient::class, $client->getHttpClient());
        $this->assertInstanceOf(HttpClientFactory::class, $client->getHttpClientFactory());
    }

    public function testWhenIUseApiEndPointKeyThatNotExistsIgetException(): void
    {
        $this->expectException(InvalidParameterException::class);
        $this->expectExceptionMessage('Invalid endpoint: foo');
        $client = new Client();
        $client->setEndPoint('foo');
    }

    public function testWhenIUseApiUrlThatNotSupportedIgetException(): void
    {
        $this->expectException(InvalidParameterException::class);
        $this->expectExceptionMessage('Invalid endpoint: https://foo/api');
        $client = new Client();
        $client->setEndPoint('https://foo/api');
    }

    public function testWhenIUseAValidEndpointKeyClienShouldConfiguredWIthCorrectBaseUri(): void
    {
        $container = [];
        $history = Middleware::history($container);
        $mock = new MockHandler([
            new Response(200, [], '123456789'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);
        $httpClient = new HttpClient(['handler' => $handlerStack]);
        $client = Client::createWithHttpClient($httpClient);
        $client->setEndPoint('ovh-eu');

        $client->auth()->time();

        $this->assertCount(1, $container);

        $transaction = current($container);

        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals('https', $transaction['request']->getUri()->getScheme());
        $this->assertEquals('eu.api.ovh.com', $transaction['request']->getUri()->getHost());
        $this->assertEquals('/1.0/auth/time', $transaction['request']->getUri()->getPath());
    }

    public function testWhenIUseAValidEndpointUrlClienShouldConfiguredWIthCorrectBaseUri(): void
    {
        $container = [];
        $history = Middleware::history($container);
        $mock = new MockHandler([
            new Response(200, [], '123456789'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);
        $httpClient = new HttpClient(['handler' => $handlerStack]);
        $client = Client::createWithHttpClient($httpClient, 'https://eu.api.soyoustart.com/1.0');

        $client->auth()->time();

        $this->assertCount(1, $container);

        $transaction = current($container);

        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals('https', $transaction['request']->getUri()->getScheme());
        $this->assertEquals('eu.api.soyoustart.com', $transaction['request']->getUri()->getHost());
        $this->assertEquals('/1.0/auth/time', $transaction['request']->getUri()->getPath());
    }

    public function testWhenAuthenticateRequestShouldContainsRightHeaders(): void
    {
        $container = [];
        $history = Middleware::history($container);
        $mock = new MockHandler([
            new Response(200, [], '1649596063'),
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['123456', '234567'])),
            new Response(200, [], '1649596063'),
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['123456', '234567'])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);
        $httpClient = new HttpClient(['handler' => $handlerStack]);
        $client = Client::createWithHttpClient($httpClient, 'ovh-eu');
        $client->authenticate('foo', 'bar', 'baz');

        $client->domain()->list();

        $this->assertCount(2, $container);

        $transaction = $container[1];

        $headers = $transaction['request']->getHeaders();

        $this->assertEquals('foo', $headers['X-Ovh-Application'][0]);
        $this->assertEquals('baz', $headers['X-Ovh-Consumer'][0]);
        $this->assertEquals('1649596063', $headers['X-Ovh-Timestamp'][0]);
        $this->assertEquals('$1$fd14b3d9b86e0de03c38d8d54c9615656ffc9c3f', $headers['X-Ovh-Signature'][0]);

        $container = [];
        $client->authenticate('shi', 'fu', 'mi');

        $client->domain()->list();

        $this->assertCount(2, $container);

        /** @noinspection PhpArrayIsAlwaysEmptyInspection */
        $transaction = $container[1]; // @phpstan-ignore-line

        $headers = $transaction['request']->getHeaders();

        $this->assertEquals('shi', $headers['X-Ovh-Application'][0]);
        $this->assertEquals('mi', $headers['X-Ovh-Consumer'][0]);
        $this->assertEquals('1649596063', $headers['X-Ovh-Timestamp'][0]);
        $this->assertEquals('$1$0eaf9d3038c136f289f30e24579dd4842ae09063', $headers['X-Ovh-Signature'][0]);
    }
}
