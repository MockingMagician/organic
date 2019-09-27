<?php

namespace MockingMagician\Organic\Exception;


use Throwable;

class FilePathException extends \UnexpectedValueException
{
    public function __construct(string $path = "", int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('`%s` is not a file', $path);
        parent::__construct($message, $code, $previous);
    }
}
