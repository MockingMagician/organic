<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Collection;

use MockingMagician\Organic\Directory;

/**
 * Class InodeCollection.
 *
 * @method Directory current()
 * @method Directory next()
 * @method int       key()
 * @method bool      valid()
 * @method void      rewind()
 */
class DirectoryCollection extends Collection
{
    /**
     * InodeCollection constructor.
     *
     * @param Directory[] $Directories
     */
    public function __construct(array $Directories = [])
    {
        parent::__construct($Directories, [Directory::class]);
    }

    /**
     * @param string[] $paths
     *
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
