<?php

namespace Hikingyo\Ovh\EndPoint;

use Hikingyo\Ovh\Client;
use Hikingyo\Ovh\Exception\NeedAuthenticationException;
use Hikingyo\Ovh\HttpClient\ApiResponse;
use Hikingyo\Ovh\HttpClient\QueryFragmentBuilder;
use Http\Client\Exception;

abstract class AbstractEndPoint
{
    private Client $client;

    private QueryFragmentBuilder $queryStringBuilder;

    public function __construct(Client $client, QueryFragmentBuilder $queryFragmentBuilder = null)
    {
        $this->client = $client;
        $this->queryStringBuilder = $queryFragmentBuilder ?? new QueryFragmentBuilder();
    }

    /**
     * @throws Exception
     */
    protected function get(string $url, array $params = [], array $headers = [], bool $needAuthentication = true)
    {
        if ($needAuthentication && !$this->client->getHttpClientFactory()->hasAuthentication()) {
            throw new NeedAuthenticationException();
        }

        $uri = $this->client->getHttpClientFactory()->getUriFactory()->createUri($url);
        $uri->withFragment($this->prepareFragments($params));

        $response = $this->client->getHttpClient()->get($uri, $headers);

        $response = new ApiResponse($response);

        return $response->getContent();
    }

    protected function getClient(): Client
    {
        return $this->client;
    }

    private function prepareFragments(array $params): string
    {
        $params = array_filter($params, static function ($value): bool {
            return null !== $value;
        });

        return $this->queryStringBuilder->buildFragments($params);
    }
}
