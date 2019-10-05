<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

interface FileInterface extends InodeInterface
{
    /**
     * Get an interface for read or write in file.
     *
     * @param string $openMode
     *
     * @return IOFileInterface
     */
    public function getIO(string $openMode = 'r'): IOFileInterface;
}
