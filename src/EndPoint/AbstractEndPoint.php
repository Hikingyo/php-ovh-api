<?php

namespace Hikingyo\Ovh\EndPoint;

use Hikingyo\Ovh\Client;
use Hikingyo\Ovh\Exception\InvalidParameterException;
use Hikingyo\Ovh\Exception\NeedAuthenticationException;
use Hikingyo\Ovh\HttpClient\ApiResponse;
use Hikingyo\Ovh\HttpClient\QueryStringBuilder;
use Http\Client\Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractEndPoint
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws Exception
     * @throws InvalidParameterException
     */
    protected function get(string $uri, array $params = [], array $headers = [], bool $needAuthentication = true)
    {
        if ($needAuthentication && !$this->isAuthenticated()) {
            throw new NeedAuthenticationException();
        }

        $response = $this->client->getHttpClient()->get($this->prepareUri($uri, $params), $headers);
        $response = new ApiResponse($response);

        return $response->getContent();
    }

    protected function getOptionResolver(): OptionsResolver
    {
        return new OptionsResolver();
    }

    protected function getClient(): Client
    {
        return $this->client;
    }

    private function prepareUri(string $uri, array $params): string
    {
        $params = array_filter($params, static function ($value): bool {
            return null !== $value;
        });

        return sprintf('%s%s', $uri, QueryStringBuilder::build($params));
    }

    private function isAuthenticated(): bool
    {
        return $this->client->getHttpClientFactory()->hasAuthentication();
    }
}
