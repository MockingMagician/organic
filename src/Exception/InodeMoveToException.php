<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Exception;

use Throwable;

class InodeMoveToException extends \Exception
{
    public function __construct(string $originPath, string $toPath, string $reason, int $code = 0, Throwable $previous = null)
    {
        $message = \sprintf('Moving `%s` to `%s` has failed: %s', $originPath, $toPath, $reason);
        parent::__construct($message, $code, $previous);
    }
}
