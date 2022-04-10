<?php

namespace Hikingyo\Ovh\HttpClient;

use function array_keys;
use function array_map;
use function implode;
use function is_array;
use function sprintf;

class QueryFragmentBuilder
{
    public function buildFragments(array $params): string
    {
        $queryParams = array_map(
            function ($value, $key): string {
                return $this->encode($value, $key);
            },
            $params,
            array_keys($params)
        );

        $queryParams = implode('&', $queryParams);

        return sprintf('?%s', $queryParams);
    }

    private function encode($query, $prefix): string
    {
        if (!is_array($query)) {
            return $this->rawUrlEncode($prefix) . '=' . $this->rawUrlEncode($query);
        }

        $isList = array_is_list($query);

        $params = array_map(
            function ($value, $key) use ($prefix, $isList): string {
                $prefix = $isList ? $prefix . '[]' : $prefix . '[' . $key . ']';

                return $this->encode($value, $prefix);
            },
            $query,
            array_keys($query)
        );

        return implode('&', $params);
    }

    private function rawUrlEncode($value): string
    {
        if (false === $value) {
            return 'false';
        }

        if (true === $value) {
            return 'true';
        }

        return rawurlencode((string) $value);
    }
}
