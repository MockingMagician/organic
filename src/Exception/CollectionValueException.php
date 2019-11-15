<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Exception;

use Throwable;

class CollectionValueException extends \Exception
{
    public function __construct(string $collectionClass, $value, int $code = 0, Throwable $previous = null)
    {
        $valueClassOrType = 'object' === ($type = \gettype($value)) ? \get_class($value) : $type;
        $message = \sprintf('Collection `%s` can not accept `%s` object', $collectionClass, $valueClassOrType);
        parent::__construct($message, $code, $previous);
    }
}
