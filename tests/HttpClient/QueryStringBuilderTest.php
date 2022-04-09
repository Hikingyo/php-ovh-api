<?php

namespace Hikingyo\Ovh\Tests\HttpClient;

use Hikingyo\Ovh\HttpClient\QueryStringBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class QueryStringBuilderTest extends TestCase
{
    /**
     * @dataProvider queryStringProvider
     */
    public function testBuild(array $query, string $expected): void
    {
        $this->assertSame(\sprintf('?%s', $expected), QueryStringBuilder::build($query));
    }

    public function queryStringProvider()
    {
        yield 'indexed array' => [
            [
                'key' => [88, 86],
            ],
            'key%5B%5D=88&key%5B%5D=86',
        ];

        yield 'non-indexed array with only numeric keys' => [
            [
                'key' => [0 => 88, 2 => 86],
            ],
            'key%5B0%5D=88&key%5B2%5D=86',
        ];

        yield 'indexed array with multiple entries' => [
            [
                'key1' => 'value1',
                'key2' => 'value2',
                'key3' => 'value3',
                'key4' => '0',
                'key5' => 0,
            ],
            'key1=value1&key2=value2&key3=value3&key4=0&key5=0',
        ];

        yield 'boolean encoding with multiple entries' => [
            [
                'key1' => false,
                'key2' => true,
            ],
            'key1=false&key2=true',
        ];

        yield 'deeply nested array' => [
            [
                'key1' => 'value1',
                'key2' => 'true',
                'key3' => [88, 86],
                'key4' => [
                    'a' => 'b',
                    'c' => [
                        'd' => 'e',
                        'f' => 'g',
                    ],
                ],
                'key5' => [
                    'a' => [
                        [
                            'b' => 'c',
                        ],
                        [
                            'd' => 'e',
                            'f' => [
                                'g' => 'h',
                                'i' => 'j',
                                'k' => [87, 89],
                            ],
                        ],
                    ],
                ],
            ],
            'key1=value1&key2=true&key3%5B%5D=88&key3%5B%5D=86&key4%5Ba%5D=b&key4%5Bc%5D%5Bd%5D=e&' .
            'key4%5Bc%5D%5Bf%5D=g&key5%5Ba%5D%5B%5D%5Bb%5D=c&key5%5Ba%5D%5B%5D%5Bd%5D=e&' .
            'key5%5Ba%5D%5B%5D%5Bf%5D%5Bg%5D=h&key5%5Ba%5D%5B%5D%5Bf%5D%5Bi%5D=j&' .
            'key5%5Ba%5D%5B%5D%5Bf%5D%5Bk%5D%5B%5D=87&key5%5Ba%5D%5B%5D%5Bf%5D%5Bk%5D%5B%5D=89',
        ];
    }
}
