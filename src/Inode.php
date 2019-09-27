<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

use MockingMagician\Organic\Collection\Collection;

abstract class Inode extends \SplFileInfo
{
    /** @var Collection */
    protected $attachedCollection;

    public function isDirectory(): bool
    {
        return $this->isDir();
    }

    public function attachTo(Collection $collection): void
    {
        if (null !== $this->attachedCollection) {
            $this->attachedCollection->remove($this);
        }
        $collection->add($this);

        $this->attachedCollection = $collection;
    }

    public function detachFromCollection(): void
    {
        if (null !== $this->attachedCollection) {
            $this->attachedCollection->remove($this);
        }
    }

    abstract public function delete(): bool;

    // TODO check this out
    public function moveTo(string $path): bool
    {
        return rename($this->getRealPath(), $path);
    }
}
