<?php

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
     * @return File
     * @throws FilePathException
     * @throws InodePathException
     */
    public static function file(string $path): File
    {
        return new File($path);
    }

    /**
     * @param string $path
     * @return File
     * @throws FilePathException
     * @throws InodePathException
     * @throws FileAlreadyExistException
     */
    public static function newFile(string $path): File
    {
        return File::create($path);
    }

    /**
     * @param string $path
     * @return Directory
     * @throws DirectoryPathException
     * @throws InodePathException
     */
    public static function directory(string $path): Directory
    {
        return new Directory($path);
    }

    /**
     * @param string $path
     * @return Directory
     * @throws DirectoryPathException
     * @throws InodePathException
     * @throws DirectoryCreateException
     */
    public static function createDirectory(string $path): Directory
    {
        return Directory::create($path);
    }
}
