<?php

namespace Core\Exception;

class NotFoundException extends \Exception
{
    public function __construct(string $message = "Not Found", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
