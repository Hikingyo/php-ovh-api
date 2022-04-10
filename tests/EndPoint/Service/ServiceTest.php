<?php

namespace Hikingyo\Ovh\Tests\EndPoint\Service;

use Hikingyo\Ovh\EndPoint\Service\Service;
use Hikingyo\Ovh\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @internal
 */
class ServiceTest extends TestCase
{
    public function testList(): void
    {
        $expected = [
            33123887,
            17231501,
            17231502,
            17231499,
            21790926,
            21790928,
        ];

        /** @var MockObject|Service $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/service')
            ->willReturn($expected)
        ;

        $actual = $api->list();

        $this->assertEquals($expected, $actual);
    }

    protected function getEndPointClass(): string
    {
        return Service::class;
    }
}
