<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

interface InodeInterface extends FileInfoInterface
{
    /**
     * Delete the inode. An inode is a file or a directory.
     *
     * @return bool in case of success
     */
    public function delete(): bool;

    /**
     * @param string $path
     *
     * @return InodeInterface
     */
    public static function create(string $path): InodeInterface;

    /**
     * @param string $path
     *
     * @return InodeInterface
     */
    public function createLink(string $path): InodeInterface;
}
