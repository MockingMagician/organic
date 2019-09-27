<?php

namespace MockingMagician\Organic;


/**
 * Class InodeCollection
 * @package MockingMagician\Organic
 * @method File current()
 * @method File next()
 */
class FileCollection extends Collection
{
    /**
     * InodeCollection constructor.
     * @param Directory[] $Directories
     */
    public function __construct(array $Directories = [])
    {
        parent::__construct($Directories, [File::class]);
    }

    /**
     * @param string[] $paths
     * @return self
     */
    public static function createFromPaths(array $paths): CollectionInterface
    {
        $inodes = [];
        foreach ($paths as $path) {
            $inode = new File($path);
            $inodes[] = $inode;
        }

        return new static($inodes);
    }
}
