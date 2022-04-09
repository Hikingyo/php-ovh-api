<?php

namespace Hikingyo\Ovh\Tests\EndPoint\Domain;

use Hikingyo\Ovh\EndPoint\Domain\Domain;
use Hikingyo\Ovh\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @internal
 * @coversNothing
 */
class DomainTest extends TestCase
{
    public function testItShouldReturnListOfAvailableDomain()
    {
        $expected = [
            'domain.com',
            'domain2.com',
        ];

        /** @var Domain|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/domain')
            ->willReturn($expected)
        ;

        $actual = $api->list();

        $this->assertEquals($expected, $actual);
    }

    protected function getEndPointClass(): string
    {
        return Domain::class;
    }
}
