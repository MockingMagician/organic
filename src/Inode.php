<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

use MockingMagician\Organic\Collection\Collection;
use MockingMagician\Organic\Exception\DirectoryMoveException;

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

    public function moveTo(string $path): bool
    {
        try {
            \rename($this->getRealPath(), $path);
        } catch (\Throwable $e) {
            throw new DirectoryMoveException($this->getRealPath(), $path, $e);
        }

        return true;
    }
}
