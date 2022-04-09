<?php

namespace Hikingyo\Ovh\HttpClient\Plugin;

use Hikingyo\Ovh\Exception\HttpExceptionInterface;
use Hikingyo\Ovh\Exception\ResourceNotFoundException;
use Hikingyo\Ovh\Exception\RuntimeException;
use Hikingyo\Ovh\HttpClient\ApiResponse;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ExceptionThrower implements Plugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(
            /**
             * @throws HttpExceptionInterface
             */
            function (ResponseInterface $response): ResponseInterface {
                $response = new ApiResponse($response);
                $statusCode = $response->getStatusCode();

                if ($statusCode >= 400 && $statusCode < 600) {
                    throw self::createException($statusCode, $response->getErrorMessage() ?? $response->getReasonPhrase());
                }

                return $response->getResponse();
            }
        );
    }

    private static function createException(int $status, string $message): HttpExceptionInterface
    {
        if (404 === $status) {
            return new ResourceNotFoundException($message);
        }

        return new RuntimeException($message);
    }
}
