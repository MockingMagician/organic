<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

use MockingMagician\Organic\Collection\DirectoryCollection;
use MockingMagician\Organic\Collection\FileCollection;
use MockingMagician\Organic\Collection\InodeCollection;
use MockingMagician\Organic\Exception\DirectoryCreateException;
use MockingMagician\Organic\Exception\DirectoryDeleteException;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Helper\FilesystemIteratorFactory;

class Directory extends Inode
{
    /** @var FilesystemIteratorFactory */
    private $filesystemIterator;

    public function __construct(string $path)
    {
        parent::__construct($path);

        if (!$this->isDirectory()) {
            throw new DirectoryPathException($path);
        }

        $this->filesystemIterator = new FilesystemIteratorFactory($this);
    }

    /**
     * @return FileCollection
     */
    public function getFiles(): FileCollection
    {
        return FileCollection::createFromPaths(
            $this->getPaths($this->filesystemIterator->createFileSystemIteratorOnlyFiles())
        );
    }

    /**
     * @return FileCollection
     */
    public function getRecursiveFiles(): FileCollection
    {
        return FileCollection::createFromPaths(
            $this->getPaths($this->filesystemIterator->createRecursiveFileSystemIteratorOnlyFiles())
        );
    }

    /**
     * @return DirectoryCollection
     */
    public function getDirectories(): DirectoryCollection
    {
        return DirectoryCollection::createFromPaths(
            $this->getPaths($this->filesystemIterator->createFileSystemIteratorOnlyDirectories())
        );
    }

    /**
     * @return DirectoryCollection
     */
    public function getRecursiveDirectories(): DirectoryCollection
    {
        return DirectoryCollection::createFromPaths(
            $this->getPaths($this->filesystemIterator->createRecursiveFileSystemIteratorOnlyDirectories())
        );
    }

    /**
     * @return InodeCollection
     */
    public function getInodes(): InodeCollection
    {
        return InodeCollection::createFromPaths(
            $this->getPaths($this->filesystemIterator->createFileSystemIterator())
        );
    }

    /**
     * @return InodeCollection
     */
    public function getRecursiveInodes(): InodeCollection
    {
        return InodeCollection::createFromPaths(
            $this->getPaths($this->filesystemIterator->createRecursiveFileSystemIterator())
        );
    }

    public function delete(): bool
    {
        try {
            /** @var Inode $inode */
            foreach ($this->getRecursiveInodes() as $inode) {
                $inode->delete();
            }
            \rmdir($this->getRealPath());
        } catch (\Throwable $e) {
            throw new DirectoryDeleteException($this->getRealPath(), $e);
        }
        $this->detachFromCollection();

        return true;
    }

    public static function createDirectory(string $path, $permissions = 0777): Directory
    {
        if (\is_dir($path)) {
            $directory = new Directory($path);
        } else {
            try {
                \mkdir($path, $permissions, true);
                $directory = new Directory($path);
            } catch (\Throwable $e) {
                throw new DirectoryCreateException($path, $e);
            }
        }

        return $directory;
    }

    public function createSubDirectory(string $directoryName, $permissions = 0777): Directory
    {
        $path = $this->getRealPath().\DIRECTORY_SEPARATOR.$directoryName;

        $directory = static::createDirectory($path);

        if (null !== $this->attachedCollection) {
            $this->attachedCollection->add($directory);
        }

        return $directory;
    }

    /**
     * @param \Iterator $iterator
     *
     * @return string[]
     */
    private function getPaths(\Iterator $iterator): array
    {
        $paths = [];

        /** @var \SplFileInfo $fileInfo */
        foreach ($iterator as $fileInfo) {
            $paths[] = $fileInfo->getRealPath();
        }

        $paths = \array_unique($paths);
        \sort($paths);

        return $paths;
    }
}
