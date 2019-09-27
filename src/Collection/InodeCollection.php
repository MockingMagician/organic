<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Collection;

use MockingMagician\Organic\Directory;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\File;
use MockingMagician\Organic\Inode;

/**
 * Class InodeCollection.
 *
 * @method Inode current()
 * @method Inode next()
 */
class InodeCollection extends Collection
{
    /**
     * InodeCollection constructor.
     *
     * @param Inode[] $inodes
     */
    public function __construct(array $inodes = [])
    {
        parent::__construct($inodes, [File::class, Directory::class]);
    }

    /**
     * @param string[] $paths
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
