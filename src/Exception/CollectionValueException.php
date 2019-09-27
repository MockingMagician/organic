<?php

namespace MockingMagician\Organic\Exception;


use Throwable;

class CollectionValueException extends \UnexpectedValueException
{
    public function __construct(string $collectionClass, string $valueClass, int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('Collection `%s` can not accept `%s` object', $collectionClass, $valueClass);
        parent::__construct($message, $code, $previous);
    }

}