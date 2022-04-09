<?php

namespace Hikingyo\Ovh\HttpClient;

use function array_unique;
use function implode;
use function in_array;
use function is_array;
use function is_int;
use function is_string;
use function json_decode;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use function sprintf;
use function strpos;

class ApiResponse
{
    /**
     * @var string
     */
    private const FORMAT = '"%s" %s';
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function ArrayJsonEncode(array $value): string
    {
        try {
            $json = json_encode($value, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new RuntimeException(sprintf('Error while encode array into json: %s', $jsonException->getMessage()), $jsonException->getCode(), $jsonException);
        }

        return $json;
    }

    public function getErrorMessage(): ?string
    {
        try {
            $content = $this->getContent();
        } catch (RuntimeException $runtimeException) {
            return null;
        }

        if (!is_array($content)) {
            return null;
        }

        if (isset($content['message'])) {
            $message = $content['message'];

            if (is_string($message)) {
                return $message;
            }

            if (is_array($message)) {
                return $this->stringify($message);
            }
        }

        if (isset($content['error_description'])) {
            $error = $content['error_description'];

            if (is_string($error)) {
                return $error;
            }
        }

        if (isset($content['error'])) {
            $error = $content['error'];

            if (is_string($error)) {
                return $error;
            }
        }

        return null;
    }

    public function getContent()
    {
        $body = $this->response->getBody()->getContents();

        if (!in_array(
            $body,
            ['', 'null', 'true', 'false'],
            true
        ) && 0 === strpos($this->response->getHeaderLine('Content-Type'), 'application/json')) {
            return $this->jsonDecode($body);
        }

        return $body;
    }

    public function getReasonPhrase(): string
    {
        return $this->response->getReasonPhrase();
    }

    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    private function jsonDecode(string $json)
    {
        try {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new RuntimeException(sprintf('json_decode error: %s', $jsonException->getMessage()), $jsonException->getCode(), $jsonException);
        }

        return $data;
    }

    private function stringify(array $message): string
    {
        $errors = [];

        foreach ($message as $field => $messages) {
            if (is_array($messages)) {
                $messages = array_unique($messages);
                foreach ($messages as $message) {
                    $errors[] = sprintf(self::FORMAT, $field, $message);
                }
            } elseif (is_int($field)) {
                $errors[] = $messages;
            } else {
                $errors[] = sprintf(self::FORMAT, $field, $messages);
            }
        }

        return implode(', ', $errors);
    }
}
