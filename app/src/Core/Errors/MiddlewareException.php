<?php

namespace Core\Errors;

use Exception;

class MiddlewareException extends Exception
{
    public function __construct(string $message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
