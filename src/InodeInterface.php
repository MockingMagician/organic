<?php

namespace MockingMagician\Organic;


interface InodeInterface extends FileInfoInterface
{
    /**
     * Delete the inode. An inode is a file or a directory
     * @return bool in case of success
     */
    public function delete(): bool;

    /**
     * @param string $path
     * @return InodeInterface
     */
    public static function create(string $path): InodeInterface;
}
