<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Inode;

use MockingMagician\Organic\Collection\DirectoryCollection;
use MockingMagician\Organic\Collection\FileCollection;
use MockingMagician\Organic\Collection\InodeCollection;
use MockingMagician\Organic\Exception\CollectionValueException;
use MockingMagician\Organic\Exception\DirectoryAlreadyExistException;
use MockingMagician\Organic\Exception\DirectoryCreateException;
use MockingMagician\Organic\Exception\DirectoryDeleteException;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\FS\FSIterator;
use MockingMagician\Organic\FS\FSIteratorOnlyDir;
use MockingMagician\Organic\FS\FSIteratorOnlyFiles;
use MockingMagician\Organic\Inode\Base\AbstractInode;
use MockingMagician\Organic\Inode\Base\InodeInterface;
use MockingMagician\Organic\Permission\Permission;
use MockingMagician\Organic\Permission\PermissionFactory;
use MockingMagician\Organic\Size\Size;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Directory extends AbstractInode
{
    /**
     * Directory constructor.
     *
     * @throws DirectoryPathException
     */
    public function __construct(string $path)
    {
        try {
            parent::__construct($path);
        } catch (InodePathException $e) {
            throw new DirectoryPathException($path, 0, $e);
        }
        if (!$this->isDirectory()) {
            throw new DirectoryPathException($this->getObjectPath());
        }
    }

    /**
     * @param Permission $permission
     *
     * @throws DirectoryAlreadyExistException
     * @throws DirectoryCreateException
     * @throws DirectoryPathException
     *
     * @return Directory
     */
    public static function create(string $path, Permission $permission = null, bool $recursive = true): InodeInterface
    {
        \clearstatcache(true, $path);
        if (\file_exists($path)) {
            throw new DirectoryAlreadyExistException($path);
        }

        if (null === $permission) {
            $permission = PermissionFactory::defaultDirectory();
        }

        try {
            \mkdir($path, $permission->getMode(), $recursive);
            // chmod enforce mode that is not fully qualified through mkdir cause umask setting
            // we not want to change umask cause onto multithreaded server umask value is shared across the threads
            // so changing umask can affect other threads and "vice & versa"
            \chmod($path, $permission->getMode());
        } catch (\Throwable $e) {
            throw new DirectoryCreateException($path, $e);
        }

        return new static($path);
    }

    /**
     * Delete the inode. An inode is a file or a directory.
     *
     * @throws DirectoryDeleteException
     *
     * @return bool in case of success
     */
    public function delete(bool $ignoreIsNotEmpty = false): bool
    {
        if ($ignoreIsNotEmpty) {
            $this->clear();
        }

        try {
            return \rmdir($this->getObjectPath());
        } catch (\Throwable $e) {
            throw new DirectoryDeleteException($this->getObjectPath(), $e);
        }
    }

    /**
     * Delete the directory content.
     *
     * @throws DirectoryDeleteException
     *
     * @return bool in case of success
     */
    public function clear(): bool
    {
        try {
            $inodes = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->getObjectPath(), RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );

            /** @var \SplFileInfo $fileInfo */
            foreach ($inodes as $fileInfo) {
                if ($fileInfo->isDir()) {
                    \rmdir($fileInfo->getPathname());

                    continue;
                }
                \unlink($fileInfo->getPathname());
            }
        } catch (\Throwable $e) {
            throw new DirectoryDeleteException($this->getObjectPath(), $e);
        }

        return true;
    }

    /**
     * @throws CollectionValueException
     * @throws DirectoryPathException
     * @throws InodePathException
     */
    public function getInodes(): InodeCollection
    {
        $fs = new FSIterator($this->getObjectPath());

        var_dump(\iterator_to_array($fs->getIterator()));

        return InodeCollection::createFromPaths();
    }

    /**
     * @throws CollectionValueException
     * @throws DirectoryPathException
     * @throws FilePathException
     */
    public function getFiles(): FileCollection
    {
        $fs = new FSIteratorOnlyFiles($this->getObjectPath());

        return FileCollection::createFromPaths(\iterator_to_array($fs->getIterator()));
    }

    /**
     * @throws CollectionValueException
     * @throws DirectoryPathException
     */
    public function getDirectories(): DirectoryCollection
    {
        $fs = new FSIteratorOnlyDir($this->getObjectPath());

        return DirectoryCollection::createFromPaths(\iterator_to_array($fs->getIterator()));
    }

    /**
     * @throws CollectionValueException
     * @throws DirectoryPathException
     * @throws InodePathException
     */
    public function getSize(): Size
    {
        $size = 0;

        $inodes = $this->getInodes();
        foreach ($inodes as $inode) {
            if ($inode instanceof File) {
                $size += $inode->getSize()->bytes();
            }
        }

        return new Size($size);
    }
}
