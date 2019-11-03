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

class FileSystem
{
    /**
     * @param string $path
     *
     * @throws FilePathException
     * @throws InodePathException
     *
     * @return File
     */
    public static function file(string $path): File
    {
        return new File($path);
    }

    /**
     * @param string $path
     *
     * @throws FilePathException
     * @throws InodePathException
     * @throws FileAlreadyExistException
     *
     * @return File
     */
    public static function newFile(string $path): File
    {
        return File::create($path);
    }

    /**
     * @param string $path
     *
     * @throws DirectoryPathException
     * @throws InodePathException
     *
     * @return Directory
     */
    public static function directory(string $path): Directory
    {
        return new Directory($path);
    }

    /**
     * @param string $path
     *
     * @throws DirectoryPathException
     * @throws InodePathException
     * @throws DirectoryCreateException
     *
     * @return Directory
     */
    public static function createDirectory(string $path): Directory
    {
        return Directory::create($path);
    }
}
