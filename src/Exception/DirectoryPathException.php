<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Exception;

use Throwable;

class DirectoryPathException extends \UnexpectedValueException
{
    public function __construct(string $path = '', int $code = 0, Throwable $previous = null)
    {
        $message = \sprintf('`%s` is not a directory', $path);
        parent::__construct($message, $code, $previous);
    }
}
