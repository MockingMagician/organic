<?php

namespace MockingMagician\Organic;

use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Exception\InodePathException;

/**
 * Class InodeCollection
 * @package MockingMagician\Organic
 * @method Directory current()
 * @method Directory next()
 */
class DirectoryCollection extends Collection
{
    /**
     * InodeCollection constructor.
     * @param Directory[] $Directories
     */
    public function __construct(array $Directories = [])
    {
        parent::__construct($Directories, [Directory::class]);
    }

    /**
     * @param string[] $paths
     * @return self
     */
    public static function createFromPaths(array $paths): DirectoryCollection
    {
        $inodes = [];
        foreach ($paths as $path) {
            $inode = new Directory($path);
            $inodes[] = $inode;
        }

        return new static($inodes);
    }
}
