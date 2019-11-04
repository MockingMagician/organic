<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Collection;

use MockingMagician\Organic\Exception\CollectionValueException;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\Inode\Base\AbstractInode;
use MockingMagician\Organic\Inode\Directory;
use MockingMagician\Organic\Inode\File;

/**
 * Class InodeCollection.
 *
 * @method AbstractInode current()
 * @method AbstractInode next()
 * @method int           key()
 * @method bool          valid()
 * @method void          rewind()
 */
class InodeCollection extends AbstractCollection
{
    /**
     * InodeCollection constructor.
     *
     * @param AbstractInode[] $inodes
     *
     * @throws CollectionValueException
     */
    public function __construct(array $inodes = [])
    {
        parent::__construct($inodes, [File::class, Directory::class]);
    }

    /**
     * @param string[] $paths
     *
     * @throws InodePathException
     * @throws CollectionValueException
     *
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
