<?php

namespace Hikingyo\Ovh\HttpClient;

use function array_keys;
use function array_map;
use function count;
use function implode;
use function is_array;
use function range;
use function sprintf;

class QueryStringBuilder
{
    public static function build(array $params): string
    {
        $queryParams = array_map(
            static function ($value, $key): string {
                return self::encode($value, $key);
            },
            $params,
            array_keys($params)
        );

        $queryParams = implode('&', $queryParams);

        return sprintf('?%s', $queryParams);
    }

    private static function encode($query, $prefix): string
    {
        if (!is_array($query)) {
            return self::rawUrlEncode($prefix) . '=' . self::rawUrlEncode($query);
        }

        $isList = self::isList($query);

        return implode('&', array_map(static function ($value, $key) use ($prefix, $isList): string {
            $prefix = $isList ? $prefix . '[]' : $prefix . '[' . $key . ']';

            return self::encode($value, $prefix);
        }, $query, array_keys($query)));
    }

    private static function rawUrlEncode($value): string
    {
        if (false === $value) {
            return 'false';
        }

        if (true === $value) {
            return 'true';
        }

        return rawurlencode((string) $value);
    }

    private static function isList(array $query): bool
    {
        if (empty($query)) {
            return false;
        }

        if (!isset($query[0])) {
            return false;
        }

        return array_keys($query) === range(0, count($query) - 1);
    }
}
