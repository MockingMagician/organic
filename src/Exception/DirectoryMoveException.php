<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Exception;

use Throwable;

class DirectoryMoveException extends \RuntimeException
{
    public function __construct(string $originalPath, string $newPath, Throwable $exception, int $code = 0, Throwable $previous = null)
    {
        $message = \sprintf(
            'Moving `%s` directory to `%s` has failed: %s',
            $originalPath,
            $newPath,
            $exception->getMessage()
        );
        parent::__construct($message, $code, $previous);
    }
}
