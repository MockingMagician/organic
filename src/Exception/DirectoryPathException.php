<?php

namespace MockingMagician\Organic\Exception;


use Throwable;

class DirectoryPathException extends \UnexpectedValueException
{
    public function __construct(string $path = "", int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('`%s` is not a directory', $path);
        parent::__construct($message, $code, $previous);
    }
}
