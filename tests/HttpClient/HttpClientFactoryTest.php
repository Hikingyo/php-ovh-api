<?php

namespace Hikingyo\Ovh\Tests\HttpClient;

use Hikingyo\Ovh\HttpClient\HttpClientFactory;
use Http\Client\Common\HttpMethodsClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @internal
 * @coversNothing
 */
class HttpClientFactoryTest extends TestCase
{
    private HttpClientFactory $httpClientFactory;

    /**
     * @before
     */
    public function initHttpClientFactory(): void
    {
        $client = $this->createMock(ClientInterface::class);
        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $streaFactory = $this->createMock(StreamFactoryInterface::class);
        $this->httpClientFactory = new HttpClientFactory(
            $client,
            $requestFactory,
            $streaFactory
        );
    }

    public function testHttpClientShouldBeAnInstanceOfHttpMethodsClient(): void
    {
        $actual = $this->httpClientFactory->getHttpClient();
        $this->assertInstanceOf(HttpMethodsClient::class, $actual);
    }

    public function testStreamFactoryShouldBeAStreamFactory(): void
    {
        $this->assertInstanceOf(StreamFactoryInterface::class, $this->httpClientFactory->getStreamFactory());
    }
}
