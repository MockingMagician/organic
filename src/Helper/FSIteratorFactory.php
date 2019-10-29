<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Helper;

use MockingMagician\Organic\Directory;

/**
 * Class FilesystemIteratorFactory.
 *
 * @internal
 */
class FSIteratorFactory
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
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
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
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
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
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
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
