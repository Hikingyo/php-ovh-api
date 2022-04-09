<?php

namespace Hikingyo\Ovh\Exception;

use RuntimeException as BaseRuntimeException;

class RuntimeException extends BaseRuntimeException implements HttpExceptionInterface
{
}
