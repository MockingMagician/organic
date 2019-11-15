<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Collection;

use MockingMagician\Organic\Exception\CollectionValueException;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Inode\Directory;

/**
 * Class InodeCollection.
 *
 * @method Directory current()
 * @method Directory next()
 * @method int       key()
 * @method bool      valid()
 * @method void      rewind()
 */
class DirectoryCollection extends AbstractCollection
{
    /**
     * InodeCollection constructor.
     *
     * @param Directory[] $Directories
     *
     * @throws CollectionValueException
     */
    public function __construct(array $Directories = [])
    {
        parent::__construct($Directories, [Directory::class]);
    }

    /**
     * @param string[] $paths
     *
     * @throws CollectionValueException
     * @throws DirectoryPathException
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
