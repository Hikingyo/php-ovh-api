<?php

namespace Hikingyo\Ovh\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

class Authentication implements Plugin
{
    private string $consumerKey;

    private string $applicationKey;

    private string $applicationSecret;

    private int $deltaTime;

    public function __construct(string $applicationKey, string $applicationSecret, string $consumerKey, int $deltaTime)
    {
        $this->applicationKey = $applicationKey;
        $this->applicationSecret = $applicationSecret;
        $this->consumerKey = $consumerKey;
        $this->deltaTime = $deltaTime;
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $request = $this->withHeaders($request);

        return $next($request);
    }

    private function withHeaders(RequestInterface $request): RequestInterface
    {
        $headers['X-Ovh-Application'] = $this->applicationKey;

        $now = time() + $this->deltaTime;

        $headers['X-Ovh-Timestamp'] = $now;
        $headers['X-Ovh-Consumer'] = $this->consumerKey;
        $headers['X-Ovh-Signature'] = $this->signature($request, $now);
        foreach ($headers as $name => $values) {
            $request = $request->withHeader($name, $values);
        }

        return $request;
    }

    private function signature(RequestInterface $request, int $now): string
    {
        $toSign = $this->applicationSecret . '+' . $this->consumerKey . '+' . $request->getMethod()
            . '+' . $request->getUri() . '+' . $request->getBody() . '+' . $now;

        return '$1$' . sha1($toSign);
    }
}
