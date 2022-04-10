<?php

namespace Hikingyo\Ovh\HttpClient\Exception;

use RuntimeException as BaseRuntimeException;

class RuntimeException extends BaseRuntimeException implements HttpExceptionInterface
{
}
