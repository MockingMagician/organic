<?php

namespace MockingMagician\Organic\Exception;


use Throwable;

class DirectoryDeleteException extends \RuntimeException
{
    public function __construct(string $path = "", Throwable $exception, int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('Delete `%s` directory has failed: %s', $path, $exception->getMessage());
        parent::__construct($message, $code, $previous);
    }
}
