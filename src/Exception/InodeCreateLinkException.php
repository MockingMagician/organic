<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Exception;

use Throwable;

class InodeCreateLinkException extends \Exception
{
    public function __construct(string $path, string $linkPath, string $reason, int $code = 0, Throwable $previous = null)
    {
        $message = \sprintf('Create link for `%s` to `%s` link has failed: %s', $path, $linkPath, $reason);
        parent::__construct($message, $code, $previous);
    }
}
