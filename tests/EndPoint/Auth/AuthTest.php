<?php

namespace Hikingyo\Ovh\Tests\EndPoint\Auth;

use Hikingyo\Ovh\EndPoint\Auth\Auth;
use Hikingyo\Ovh\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @internal
 */
class AuthTest extends TestCase
{
    public function testTime(): void
    {
        $expected = 1488291201;

        /** @var Auth|MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/auth/time')
            ->willReturn($expected)
        ;

        $res = $api->time();

        $this->assertIsInt($res);
    }

    protected function getEndPointClass(): string
    {
        return Auth::class;
    }
}
