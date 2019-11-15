<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Collection;

use MockingMagician\Organic\Exception\CollectionValueException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Inode\Directory;
use MockingMagician\Organic\Inode\File;

/**
 * Class InodeCollection.
 *
 * @method File current()
 * @method File next()
 * @method int  key()
 * @method bool valid()
 * @method void rewind()
 */
class FileCollection extends AbstractCollection
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
        parent::__construct($Directories, [File::class]);
    }

    /**
     * @param string[] $paths
     *
     * @throws CollectionValueException
     * @throws FilePathException
     *
     * @return self
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
