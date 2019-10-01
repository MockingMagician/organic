<?php

namespace MockingMagician\Organic;


use MockingMagician\Organic\Exception\FileAlreadyExistException;
use MockingMagician\Organic\Exception\FileCreateException;
use MockingMagician\Organic\Exception\FileDeleteException;
use MockingMagician\Organic\Exception\FileLinkCreateException;
use MockingMagician\Organic\Exception\FilePathException;

class FileObject extends AbstractInode implements FileInterface
{
    public function __construct(string $path)
    {
        parent::__construct($path);
        if (!is_file($this->path)) {
            throw new FilePathException($this->path);
        }
    }

    /**
     * Returns the files size in bytes
     * @return int
     */
    function getSize(): int
    {
        clearstatcache(true, $this->path);

        return filesize($this->path);
    }

    /**
     * Delete the inode. An inode is a file or a directory
     * @return bool in case of success
     */
    function delete(): bool
    {
        try {
            unlink($this->path);
        } catch (\Throwable $e) {
            throw new FileDeleteException($this->path, $e);
        }

        return true;
    }

    /**
     * @param string $path
     * @param $permissions
     * @return FileObject|InodeInterface
     * @throws \Exception
     */
    static function create(string $path, $permissions = 0666): InodeInterface
    {
        if (file_exists($path)) {
            throw new FileAlreadyExistException($path);
        }
        try {
            file_put_contents($path, '', LOCK_EX);
            chmod($path, $permissions);
        } catch (\Throwable $e) {
            throw new FileCreateException($path, $e);
        }
        if (!file_exists($path)) {
            throw new \Exception();
        }

        return new static($path);
    }

    /**
     * @param string $path
     * @return InodeInterface
     */
    public function createLink(string $path): InodeInterface
    {
        try {
            symlink($this->path, $path);
        } catch (\Throwable $e) {
            throw new FileLinkCreateException($this->path, $path, $e);
        }

        return new static($path);
    }

    /**
     * Get an interface for read or write in file
     * @param string $openMode
     * @return IOFileInterface
     * @throws \Exception
     */
    public function getIO(string $openMode = "r"): IOFileInterface
    {
        return new IOFile($this->path, $openMode);
    }
}
