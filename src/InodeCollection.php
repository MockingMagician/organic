<?php

namespace MockingMagician\Organic;

use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Exception\InodePathException;

/**
 * Class InodeCollection
 * @package MockingMagician\Organic
 * @method Inode current()
 * @method Inode next()
 */
class InodeCollection extends Collection
{
    /**
     * InodeCollection constructor.
     * @param Inode[] $inodes
     */
    public function __construct(array $inodes = [])
    {
        parent::__construct($inodes, [File::class, Directory::class]);
    }

    /**
     * @param string[] $paths
     * @return self
     */
    public static function createFromPaths(array $paths): self
    {
        $inodes = [];
        foreach ($paths as $path) {
            try {
                $inode = new File($path);
            } catch (FilePathException $exception) {
                try {
                    $inode = new Directory($path);
                } catch (DirectoryPathException $exception) {
                    throw new InodePathException($path);
                }
            }
            $inodes[] = $inode;
        }

        return new static($inodes);
    }
}
