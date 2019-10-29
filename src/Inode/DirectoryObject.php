<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Inode;

use MockingMagician\Organic\Inode\Base\AbstractInode;
use MockingMagician\Organic\Inode\Base\InodeInterface;
use MockingMagician\Organic\Permission\Permission;

class DirectoryObject extends AbstractInode
{
    /**
     * @param string     $path
     * @param Permission $permission
     *
     * @return InodeInterface the created Inode
     */
    public static function create(string $path, Permission $permission): InodeInterface
    {
        // TODO: Implement create() method.
    }

    /**
     * Delete the inode. An inode is a file or a directory.
     *
     * @return bool in case of success
     */
    public function delete(): bool
    {
        // TODO: Implement delete() method.
    }
}
