<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Exception;

use Throwable;

class PermissionModeException extends \Exception
{
    private const MIN_MODE = 0;
    private const MAX_MODE = 511;

    public function __construct(int $invalidMode, int $code = 0, Throwable $previous = null)
    {
        $message = \sprintf(
            'Valid mode interval is between %s (octal: 0%o) and %s (octal: 0%o). Given %s (octal: 0%s)',
            static::MIN_MODE,
            static::MIN_MODE,
            static::MAX_MODE,
            static::MAX_MODE,
            $invalidMode,
            $invalidMode
        );
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param int $mode
     *
     * @throws PermissionModeException
     */
    public static function throwOnInvalidMode(int $mode)
    {
        if ($mode < static::MIN_MODE || $mode > static::MAX_MODE) {
            throw new static($mode);
        }
    }
}
