<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\FS;

use Traversable;

class FSIteratorOnlyFiles extends FSIterator
{
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
        $scanDir = \array_filter($this->scanDir(), function ($value) {
            if (\is_file($this->path . DIRECTORY_SEPARATOR . $value)) {
                return true;
            }

            return false;
        });

        return new \ArrayIterator($scanDir);
    }
}
