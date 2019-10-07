<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

use MockingMagician\Organic\Exception\FileDeleteException;
use MockingMagician\Organic\Exception\FilePathException;

class File extends Inode
{
    /**
     * File constructor.
     *
     * @param string $path
     *
     * @throws FilePathException
     */
    public function __construct(string $path)
    {
        parent::__construct($path);

        if (!$this->isFile()) {
            throw new FilePathException($path);
        }
    }

    /**
     * @throws FileDeleteException
     *
     * @return bool
     */
    public function delete(): bool
    {
        try {
            \unlink($this->getRealPath());
        } catch (\Throwable $e) {
            throw new FileDeleteException($this->getRealPath(), $e);
        }

        return true;
    }
}
