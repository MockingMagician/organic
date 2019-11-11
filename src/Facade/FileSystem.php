<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Facade;

use MockingMagician\Organic\Exception\DirectoryAlreadyExistException;
use MockingMagician\Organic\Exception\DirectoryCreateException;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Exception\FileAlreadyExistException;
use MockingMagician\Organic\Exception\FileCreateException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Inode\Directory;
use MockingMagician\Organic\Inode\File;
use MockingMagician\Organic\Permission\Permission;
use MockingMagician\Organic\Permission\PermissionFactory;

/**
 * Class FileSystem provide a shortcut access to all important package functionality.
 *
 * @codeCoverageIgnore
 */
class FileSystem
{
    /**
     * Return a Permission object that can be easily manipulate and which is used internally by the package.
     *
     * @param int $mode
     *
     * @return Permission
     */
    public static function createPermissionFromMode(int $mode): Permission
    {
        return PermissionFactory::createFromMode($mode);
    }

    /**
     * Return the file provided by path.
     *
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
     * Return the created file provided by path.
     *
     * @param string          $path
     * @param null|Permission $permission
     *
     * @throws FileAlreadyExistException
     * @throws FilePathException
     * @throws FileCreateException
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
     * Return the directory provided by path.
     *
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
     * Return the created directory provided by path.
     *
     * @param string          $path
     * @param null|Permission $permission
     * @param bool            $recursive
     *
     * @throws DirectoryCreateException
     * @throws DirectoryPathException
     * @throws DirectoryAlreadyExistException
     *
     * @return Directory
     */
    public static function newDirectory(string $path, Permission $permission = null, bool $recursive = true): Directory
    {
        $args = [$path];
        if (null !== $permission) {
            $args[] = $permission;
            $args[] = $recursive;
        }

        return Directory::create(...$args);
    }
}
