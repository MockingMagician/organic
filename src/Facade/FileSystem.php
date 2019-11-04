<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Facade;

use MockingMagician\Organic\Exception\DirectoryCreateException;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Exception\FileAlreadyExistException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\Inode\Directory;
use MockingMagician\Organic\Inode\File;
use MockingMagician\Organic\Permission\Permission;
use MockingMagician\Organic\Permission\PermissionFactory;

class FileSystem
{
    public static function Permission(int $mode): Permission
    {
        return PermissionFactory::createFromMode($mode);
    }

    /**
     * @param string $path
     *
     * @return File
     * @throws FilePathException
     */
    public static function getFile(string $path): File
    {
        return new File($path);
    }

    /**
     * @param string $path
     *
     * @param Permission|null $permission
     * @return File
     * @throws FileAlreadyExistException
     * @throws FilePathException
     */
    public static function newFile(string $path, Permission $permission = null): File
    {
        $args = [$path];
        is_null($permission) ?: ($args[] = $permission);

        return File::create(...$args);
    }

    /**
     * @param string $path
     *
     * @throws DirectoryPathException
     *
     * @return Directory
     */
    public static function getDirectory(string $path): Directory
    {
        return new Directory($path);
    }

    /**
     * @param string $path
     *
     * @param Permission|null $permission
     * @param bool $recursive
     * @return Directory
     * @throws DirectoryCreateException
     * @throws DirectoryPathException
     */
    public static function newDirectory(string $path, Permission $permission = null, bool $recursive = true): Directory
    {
        $args = [$path];
        is_null($permission) ?: ($args[] = $permission && $args[] = $recursive);

        return Directory::create(...$args);
    }
}
