<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Inode\Base;

use MockingMagician\Organic\Exception\InodeCreateLinkException;
use MockingMagician\Organic\Exception\InodeMoveToException;
use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\Permission\Permission;

abstract class AbstractInode extends FileInfo implements InodeInterface
{
    /**
     * @throws InodeMoveToException
     * @throws InodePathException
     *
     * @return InodeInterface the moved file
     */
    public function moveTo(string $path): InodeInterface
    {
        \clearstatcache(true, $path);
        if (\file_exists($path)) {
            throw new InodeMoveToException(
                $this->getObjectPath(),
                $path,
                'A file or directory with same name already exist'
            );
        }

        try {
            \rename($this->getObjectPath(), $path);
        } catch (\Throwable $e) {
            throw new InodeMoveToException($this->getObjectPath(), $path, $e->getMessage());
        }

        $this->__construct($path);

        return $this;
    }

    /**
     * Create a symlink.
     *
     * @throws InodeCreateLinkException
     * @throws InodePathException
     */
    public function createLink(string $path): InodeInterface
    {
        \clearstatcache(true, $path);
        if (\file_exists($path)) {
            throw new InodeCreateLinkException(
                $this->getObjectPath(),
                $path,
                'A file or directory with same name already exist'
            );
        }

        try {
            \symlink($this->getObjectPath(), $path);
        } catch (\Throwable $e) {
            throw new InodeCreateLinkException($this->getObjectPath(), $path, $e->getMessage());
        }

        return new static($path);
    }

    /**
     * @return InodeInterface the created Inode
     */
    abstract public static function create(string $path, Permission $permission): InodeInterface;

    /**
     * Delete the inode. An inode is a file or a directory.
     *
     * @return bool in case of success
     */
    abstract public function delete(): bool;
}
