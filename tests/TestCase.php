<?php

namespace Hikingyo\Ovh\Tests;

use function array_merge;
use Hikingyo\Ovh\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use Psr\Http\Client\ClientInterface;

abstract class TestCase extends PhpUnitTestCase
{
    protected function getApiMock(array $methods = []): MockObject
    {
        $httpClient = $this->getMockBuilder(ClientInterface::class)
            ->onlyMethods(['sendRequest'])
            ->getMock()
        ;
        $httpClient
            ->method('sendRequest')
        ;

        $client = Client::createWithHttpClient($httpClient);

        return $this->getMockBuilder($this->getEndPointClass())
            ->onlyMethods(array_merge(
                ['get'],
                $methods
            ))
            ->setConstructorArgs([$client, null])
            ->getMock()
        ;
    }

    abstract protected function getEndPointClass(): string;
}
