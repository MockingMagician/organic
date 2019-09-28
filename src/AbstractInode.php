<?php

namespace MockingMagician\Organic;


use MockingMagician\Organic\Exception\InodePathException;

abstract class AbstractInode implements InodeInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * AbstractInode constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new InodePathException($path);
        }
        $this->path = realpath($path);
    }

    /**
     * Gets the inode change time
     * @return \DateTimeInterface
     */
    public function getCTime(): \DateTimeInterface
    {
        clearstatcache(true, $this->path);

        return (new \DateTime())->setTimestamp(filectime($this->path));
    }

    /**
     * Gets last access time of the file
     * @return \DateTimeInterface
     */
    public function getATime(): \DateTimeInterface
    {
        clearstatcache(true, $this->path);

        return (new \DateTime())->setTimestamp(fileatime($this->path));
    }

    /**
     * Gets the last modified time
     * @return \DateTimeInterface
     */
    public function getMTime(): \DateTimeInterface
    {
        clearstatcache(true, $this->path);

        return (new \DateTime())->setTimestamp(filemtime($this->path));
    }

    /**
     * Gets the base name of the file
     * @param string|null $suffix
     * @return string
     */
    public function getBasename(string $suffix = null): string
    {
        return basename($this->path, $suffix);
    }

    /**
     * Gets the file extension
     * @return string
     */
    public function getExtension(): string
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    /**
     * Gets the filename
     * @return string
     */
    public function getFilename(): string
    {
        return pathinfo($this->path, PATHINFO_FILENAME);
    }

    /**
     * Gets the file group
     * @return int
     */
    public function getGroup(): int
    {
        clearstatcache(true, $this->path);

        return filegroup($this->path);
    }

    /**
     * Returns the inode number for the filesystem object.
     * @return int
     */
    public function getInode(): int
    {
        clearstatcache(true, $this->path);

        return fileinode($this->path);
    }

    /**
     * Gets the target of a link
     * @return string
     */
    public function getLinkTarget(): string
    {
        clearstatcache(true, $this->path);

        $splFile = new \SplFileInfo($this->path);

        return $splFile->getLinkTarget();
    }

    /**
     * Gets the owner of the file
     * @return int
     */
    public function getOwner(): int
    {
        clearstatcache(true, $this->path);

        return fileowner($this->path);
    }

    /**
     * Gets the path without filename
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Gets the path without filename
     * @return string
     */
    public function getPathname(): string
    {
        return dirname($this->path);
    }

    /**
     * Gets file permissions
     * @return int
     */
    public function getPerms(): int
    {
        clearstatcache(true, $this->path);

        return fileperms($this->path);
    }

    /**
     * Gets absolute path to file
     * @return string
     */
    public function getRealPath(): string
    {
        return $this->path;
    }

    /**
     * Returns the files size in bytes
     * @return int
     */
    abstract function getSize(): int;

    /**
     * Gets file type. A string representing the type of the entry. May be one of file, link, or dir
     * @return string
     */
    public function getType(): string
    {
        clearstatcache(true, $this->path);

        return filetype($this->path);
    }

    /**
     * Tells if the file is a directory
     * @return bool
     */
    public function isDir(): bool
    {
        clearstatcache(true, $this->path);

        return is_dir($this->path);
    }

    /**
     * Tells if the file is executable
     * @return bool
     */
    public function isExecutable(): bool
    {
        clearstatcache(true, $this->path);

        return is_executable($this->path);
    }

    /**
     * Tells if the object references a regular file
     * @return bool
     */
    public function isFile(): bool
    {
        clearstatcache(true, $this->path);

        return is_file($this->path);
    }

    /**
     * Tells if the file is a link
     * @return bool
     */
    public function isLink(): bool
    {
        clearstatcache(true, $this->path);

        return is_link($this->path);
    }

    /**
     * Tells if file is readable
     * @return bool
     */
    public function isReadable(): bool
    {
        clearstatcache(true, $this->path);

        return is_readable($this->path);
    }

    /**
     * Tells if the entry is writable
     * @return bool
     */
    public function isWritable(): bool
    {
        clearstatcache(true, $this->path);

        return is_writable($this->path);
    }

    /**
     * Returns the path to the file as a string
     * @return string
     */
    public function __toString(): string
    {
        return $this->path;
    }

    /**
     * Delete the inode. An inode is a file or a directory
     * @return bool in case of success
     */
    abstract function delete(): bool;

    /**
     * @param string $path
     * @return InodeInterface
     */
    abstract static function create(string $path): InodeInterface;
}