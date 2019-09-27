<?php

namespace MockingMagician\Organic\Exception;


use Throwable;

class InodePathException extends \UnexpectedValueException
{
    public function __construct(string $path = "", int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('`%s` is not an inode', $path);
        parent::__construct($message, $code, $previous);
    }
}
