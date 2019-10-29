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
use MockingMagician\Organic\Helper\FSIteratorFactory;

class Directory extends Inode
{
    /** @var FSIteratorFactory */
    private $filesystemIterator;

    /**
     * Directory constructor.
     *
     * @param string $path
     *
     * @throws DirectoryPathException
     */
    public function __construct(string $path)
    {
        parent::__construct($path);

        if (!$this->isDirectory()) {
            throw new DirectoryPathException($path);
        }

        $this->filesystemIterator = new FSIteratorFactory($this);
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
     * @throws DirectoryPathException
     *
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
     * @throws DirectoryPathException
     *
     * @return DirectoryCollection
     */
    public function getRecursiveDirectories(): DirectoryCollection
    {
        return DirectoryCollection::createFromPaths(
            $this->getPaths($this->filesystemIterator->createRecursiveFileSystemIteratorOnlyDirectories())
        );
    }

    /**
     * @throws Exception\InodePathException
     *
     * @return InodeCollection
     */
    public function getInodes(): InodeCollection
    {
        return InodeCollection::createFromPaths(
            $this->getPaths($this->filesystemIterator->createFileSystemIterator())
        );
    }

    /**
     * @throws DirectoryPathException
     * @throws Exception\InodePathException
     *
     * @return InodeCollection
     */
    public function getRecursiveInodes(): InodeCollection
    {
        return InodeCollection::createFromPaths(
            $this->getPaths($this->filesystemIterator->createRecursiveFileSystemIterator())
        );
    }

    /**
     * @throws DirectoryDeleteException
     *
     * @return bool
     */
    public function delete(): bool
    {
        try {
            /** @var File $file */
            foreach ($this->getFiles() as $file) {
                $file->delete();
            }
            /** @var Directory $directory */
            foreach ($this->getDirectories() as $directory) {
                $directory->delete();
            }
            \rmdir($this->getRealPath());
        } catch (\Throwable $e) {
            throw new DirectoryDeleteException($this->getRealPath(), $e);
        }

        return true;
    }

    /**
     * @param string $path
     * @param int    $permissions
     *
     * @throws DirectoryCreateException
     * @throws DirectoryPathException
     *
     * @return Directory
     */
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

    /**
     * @param string $directoryName
     * @param int    $permissions
     *
     * @throws DirectoryCreateException
     * @throws DirectoryPathException
     * @throws Exception\CollectionValueException
     *
     * @return Directory
     */
    public function createSubDirectory(string $directoryName, $permissions = 0777): Directory
    {
        $path = $this->getRealPath().\DIRECTORY_SEPARATOR.$directoryName;

        $directory = static::createDirectory($path, $permissions);

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
