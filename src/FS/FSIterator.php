<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\FS;

use MockingMagician\Organic\Exception\DirectoryPathException;
use Traversable;

class FSIterator implements \IteratorAggregate
{
    protected $path;

    /**
     * FSIterator constructor.
     *
     * @param string $path
     *
     * @throws DirectoryPathException
     */
    public function __construct(string $path)
    {
        if (!\is_dir($path)) {
            throw new DirectoryPathException($path);
        }
        $this->path = $path;
    }

    /**
     * Retrieve an external iterator.
     *
     * @see http://php.net/manual/en/iteratoraggregate.getiterator.php
     *
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *                     <b>Traversable</b>
     *
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->scanDir());
    }

    protected function scanDir()
    {
        $scanDir = \scandir($this->path);

        $cleanedScanDir = \array_diff($scanDir ?: [], ['..', '.']);

        foreach ($cleanedScanDir as $k => $path) {
            $cleanedScanDir[$k] = $this->path.\DIRECTORY_SEPARATOR.$path;
        }

        return $cleanedScanDir;
    }
}
