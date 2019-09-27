<?php

namespace MockingMagician\Organic;

use MockingMagician\Organic\Exception\DirectoryDeleteException;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Helper\FilesystemIteratorFactory;

class Directory extends Inode
{
    /** @var FilesystemIteratorFactory  */
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

    /**
     * @param \Iterator $iterator
     * @return string[]
     */
    private function getPaths(\Iterator $iterator): array
    {
        $paths = [];

        /** @var \SplFileInfo $fileInfo */
        foreach ($iterator as $fileInfo) {
            $paths[] = $fileInfo->getRealPath();
        }

        $paths = array_unique($paths);
        sort($paths);

        return $paths;
    }

    public function delete(): bool
    {
        try {
            foreach ($this->getRecursiveInodes() as $inode)
            {
                $inode->delete();
            }
            rmdir($this->getRealPath());
        } catch (\Throwable $e) {
            throw new DirectoryDeleteException($this->getRealPath(), $e);
        }

        return true;
    }
}
