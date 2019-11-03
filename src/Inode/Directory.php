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
use MockingMagician\Organic\Exception\DirectoryCreateException;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\FS\FSIterator;
use MockingMagician\Organic\FS\FSIteratorOnlyDir;
use MockingMagician\Organic\FS\FSIteratorOnlyFiles;
use MockingMagician\Organic\Inode\Base\AbstractInode;
use MockingMagician\Organic\Inode\Base\InodeInterface;
use MockingMagician\Organic\Permission\Permission;
use MockingMagician\Organic\Permission\PermissionFactory;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Directory extends AbstractInode
{
    /**
     * Directory constructor.
     *
     * @param string $path
     *
     * @throws DirectoryPathException
     * @throws InodePathException
     */
    public function __construct(string $path)
    {
        parent::__construct($path);
        if (!$this->isDirectory()) {
            throw new DirectoryPathException($this->getObjectPath());
        }
    }

    /**
     * @param string     $path
     * @param Permission $permission
     * @param bool       $recursive
     *
     * @throws DirectoryCreateException
     * @throws DirectoryPathException
     * @throws InodePathException
     *
     * @return Directory
     */
    public static function create(string $path, Permission $permission = null, bool $recursive = true): InodeInterface
    {
        if (null === $permission) {
            $permission = PermissionFactory::defaultDirectory();
        }

        try {
            \mkdir($path, $permission->getMode(), $recursive);
        } catch (\Throwable $e) {
            throw new DirectoryCreateException($path, $e);
        }

        return new static($path);
    }

    /**
     * Delete the inode. An inode is a file or a directory.
     *
     * @param bool $recursive
     *
     * @return bool in case of success
     */
    public function delete(bool $recursive = false): bool
    {
        if ($recursive) {
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
        }

        return \rmdir($this->getObjectPath());
    }

    /**
     * @throws DirectoryPathException
     * @throws CollectionValueException
     *
     * @return InodeCollection
     */
    public function getInodes(): InodeCollection
    {
        $fs = new FSIterator($this->getObjectPath());

        return new InodeCollection(\iterator_to_array($fs->getIterator()));
    }

    /**
     * @throws CollectionValueException
     * @throws DirectoryPathException
     *
     * @return FileCollection
     */
    public function getFiles(): FileCollection
    {
        $fs = new FSIteratorOnlyFiles($this->getObjectPath());

        return new FileCollection(\iterator_to_array($fs->getIterator()));
    }

    /**
     * @throws CollectionValueException
     * @throws DirectoryPathException
     *
     * @return DirectoryCollection
     */
    public function getDirectories(): DirectoryCollection
    {
        $fs = new FSIteratorOnlyDir($this->getObjectPath());

        return new DirectoryCollection(\iterator_to_array($fs->getIterator()));
    }
}
