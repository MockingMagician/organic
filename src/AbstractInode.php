<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

use MockingMagician\Organic\Exception\FileLinkException;
use MockingMagician\Organic\Exception\InodePathException;

abstract class AbstractInode extends FileInfo implements InodeInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * AbstractInode constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        parent::__construct($path);
    }

    /**
     * Delete the inode. An inode is a file or a directory.
     *
     * @return bool in case of success
     */
    abstract public function delete(): bool;

    /**
     * @param string $path
     *
     * @return InodeInterface
     */
    abstract public static function create(string $path): InodeInterface;
}
