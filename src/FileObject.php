<?php

namespace MockingMagician\Organic;


use MockingMagician\Organic\Exception\FileDeleteException;
use MockingMagician\Organic\Exception\FilePathException;

class FileObject extends AbstractInode implements FileInterface
{
    public function __construct(string $path)
    {
        parent::__construct($path);
        if (!is_file($path)) {
            throw new FilePathException($path);
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
     * @return InodeInterface
     * @throws \Exception
     */
    static function create(string $path, $permissions = 0666): InodeInterface
    {
        if (file_exists($path)) {
            throw new \Exception();
        }
        try {
            $handler = fopen($path, 'x');
            flock($handler, LOCK_EX);
            fclose($handler);
            chmod($path, $permissions);
        } catch (\Throwable $e) {
            throw new \Exception();
        }
        if (!file_exists($path)) {
            throw new \Exception();
        }

        return new static($path);
    }

    /**
     * Get an interface for read or write in file
     * @param string $openMode
     * @return ReadWriteFileInterface
     * @throws \Exception
     */
    public function getReaderWriter(string $openMode = "r"): ReadWriteFileInterface
    {
        return new ReadWriteFile($this->path, $openMode);
    }
}
