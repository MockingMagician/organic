<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Collection;

use MockingMagician\Organic\Directory;
use MockingMagician\Organic\File;

/**
 * Class InodeCollection.
 *
 * @method File current()
 * @method File next()
 */
class FileCollection extends AbstractCollection
{
    /**
     * InodeCollection constructor.
     *
     * @param Directory[] $Directories
     * @throws \MockingMagician\Organic\Exception\CollectionValueException
     */
    public function __construct(array $Directories = [])
    {
        parent::__construct($Directories, [File::class]);
    }

    /**
     * @param string[] $paths
     *
     * @throws \MockingMagician\Organic\Exception\FilePathException
     *
     * @return self
     * @throws \MockingMagician\Organic\Exception\CollectionValueException
     */
    public static function createFromPaths(array $paths): FileCollection
    {
        $inodes = [];
        foreach ($paths as $path) {
            $inode = new File($path);
            $inodes[] = $inode;
        }

        return new static($inodes);
    }
}
