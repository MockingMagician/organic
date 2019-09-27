<?php

namespace MockingMagician\Organic\Helper;


use MockingMagician\Organic\Directory;

/**
 * Class FilesystemIteratorFactory
 * @package MockingMagician\Organic\Shortcut
 * @internal
 */
class FilesystemIteratorFactory
{
    private $directory;

    public function __construct(Directory $directory)
    {
        $this->directory = $directory;
    }

    /**
     * @return \Iterator|\SplFileInfo[]
     */
    public function createFileSystemIterator(): \Iterator
    {
        return new \FilesystemIterator($this->directory->getRealPath());
    }

    /**
     * @return \Iterator|\SplFileInfo[]
     */
    public function createRecursiveFileSystemIterator()
    {
        $appendIterator = new \AppendIterator();
        $path = [];
        $fileSystemIterator = $this->createFileSystemIterator();
        foreach ($fileSystemIterator as $value) {
            if ($value->isDir()) {
                $path[] = $value;
                $static = new static(new Directory($value->getRealPath()));
                $appendIterator->append($static->createRecursiveFileSystemIterator());
                continue;
            }
            if ($value->isFile()) {
                $path[] = $value;
            }
        }
        $appendIterator->append(new \ArrayIterator($path));

        return $appendIterator;
    }

    /**
     * @return \Iterator|\SplFileInfo[]
     */
    public function createFileSystemIteratorOnlyDirectories(): \Iterator
    {
        return $this->filterKeepDirOnly($this->createFileSystemIterator());
    }

    /**
     * @return \Iterator|\SplFileInfo[]
     */
    public function createRecursiveFileSystemIteratorOnlyDirectories(): \Iterator
    {
        return $this->filterKeepDirOnly($this->createRecursiveFileSystemIterator());
    }

    /**
     * @return \Iterator|\SplFileInfo[]
     */
    public function createFileSystemIteratorOnlyFiles(): \Iterator
    {
        return $this->filterKeepFileOnly($this->createFileSystemIterator());
    }

    /**
     * @return \Iterator|\SplFileInfo[]
     */
    public function createRecursiveFileSystemIteratorOnlyFiles(): \Iterator
    {
        return $this->filterKeepFileOnly($this->createRecursiveFileSystemIterator());
    }

    private function filterKeepFileOnly(\Iterator $iterator)
    {
        return new \CallbackFilterIterator(
            $iterator,
            function (\SplFileInfo $current, $key, $iterator) {
                if ($current->isFile()) {
                    return true;
                }

                return false;
            }
        );
    }

    private function filterKeepDirOnly(\Iterator $iterator)
    {
        return new \CallbackFilterIterator(
            $iterator,
            function (\SplFileInfo $current, $key, $iterator) {
                if ($current->isDir()) {
                    return true;
                }

                return false;
            }
        );
    }
}
