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
     * @throws FilePathException
     *
     * @return File
     */
    public static function getFile(string $path): File
    {
        return new File($path);
    }

    /**
     * @param string          $path
     * @param null|Permission $permission
     *
     * @throws FileAlreadyExistException
     * @throws FilePathException
     *
     * @return File
     */
    public static function newFile(string $path, Permission $permission = null): File
    {
        $args = [$path];
        null === $permission ?: ($args[] = $permission);

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
     * @param string          $path
     * @param null|Permission $permission
     * @param bool            $recursive
     *
     * @throws DirectoryCreateException
     * @throws DirectoryPathException
     *
     * @return Directory
     */
    public static function newDirectory(string $path, Permission $permission = null, bool $recursive = true): Directory
    {
        $args = [$path];
        null === $permission ?: ($args[] = $permission && $args[] = $recursive);

        return Directory::create(...$args);
    }
}
