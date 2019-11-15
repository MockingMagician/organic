<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Inode\Base;

use MockingMagician\Organic\Permission\Permission;

/**
 * Interface InodeInterface.
 */
interface InodeInterface
{
    /**
     * @return InodeInterface the created Inode
     */
    public static function create(string $path, Permission $permission): InodeInterface;

    public function moveTo(string $path): InodeInterface;

    /**
     * Delete the inode. An inode is a file or a directory.
     *
     * @return bool in case of success
     */
    public function delete(): bool;

    public function createLink(string $path): InodeInterface;
}
