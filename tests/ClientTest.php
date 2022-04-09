<?php

namespace Hikingyo\Ovh\Tests;

use Hikingyo\Ovh\Client;
use Hikingyo\Ovh\Exception\InvalidParameterException;
use Http\Client\Common\HttpMethodsClient;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ClientTest extends TestCase
{
    public function testCreateClient(): void
    {
        $client = new Client();
        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(HttpMethodsClient::class, $client->getHttpClient());
    }

    public function testWhenIUseApiEndPointKeyThatNotExistsIgetException()
    {
        $this->expectException(InvalidParameterException::class);
        $this->expectExceptionMessage('Unknown provided endpoint');
        $client = new Client();
        $client->setEndPoint('foo');
    }
}
