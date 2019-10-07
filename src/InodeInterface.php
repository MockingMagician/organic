<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

/**
 * Interface InodeInterface
 * @package MockingMagician\Organic
 *
 * An inode is something like a file, directory or similars
 */
interface InodeInterface
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
     * @return InodeInterface the created Inode
     */
    public static function create(string $path): InodeInterface;

    /**
     * @param string $path
     *
     * @return InodeInterface
     */
    public static function moveTo(string $path): InodeInterface;

    /**
     * @param string $path
     *
     * @return InodeInterface
     */
    public function createLink(string $path): InodeInterface;
}
