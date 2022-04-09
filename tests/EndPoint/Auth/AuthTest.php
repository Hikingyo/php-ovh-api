<?php

namespace Hikingyo\Ovh\Tests\EndPoint\Auth;

use Hikingyo\Ovh\EndPoint\Auth\Auth;
use Hikingyo\Ovh\Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AuthTest extends TestCase
{
    public function testTime()
    {
        $expected = 1488291201;
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
