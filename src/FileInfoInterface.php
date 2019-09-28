<?php

namespace MockingMagician\Organic;


interface FileInfoInterface
{
    /**
     * FileInfoInterface constructor.
     * @param string $path
     */
    public function __construct(string $path);

    /**
     * Gets the inode change time
     * @return \DateTimeInterface
     */
    public function getCTime(): \DateTimeInterface;

    /**
     * Gets last access time of the file
     * @return \DateTimeInterface
     */
    public function getATime(): \DateTimeInterface;

    /**
     * Gets the last modified time
     * @return \DateTimeInterface
     */
    public function getMTime(): \DateTimeInterface;

    /**
     * Gets the base name of the file
     * @param string|null $suffix
     * @return string
     */
    public function getBasename(string $suffix = null): string;

    /**
     * Gets the file extension
     * @return string
     */
    public function getExtension(): string;

    /**
     * Gets the filename
     * @return string
     */
    public function getFilename(): string;

    /**
     * Gets the file group
     * @return int
     */
    public function getGroup(): int;

    /**
     * Returns the inode number for the filesystem object.
     * @return int
     */
    public function getInode(): int;

    /**
     * Gets the target of a link
     * @return string
     */
    public function getLinkTarget(): string;

    /**
     * Gets the owner of the file
     * @return int
     */
    public function getOwner(): int;

    /**
     * Gets the path without filename
     * @return string
     */
    public function getPath(): string;

    /**
     * Gets the path without filename
     * @return string
     */
    public function getPathname(): string;

    /**
     * Gets file permissions
     * @return int
     */
    public function getPerms(): int;

    /**
     * Gets absolute path to file
     * @return string
     */
    public function getRealPath(): string;

    /**
     * Returns the files size in bytes
     * @return int
     */
    public function getSize(): int;

    /**
     * Gets file type. A string representing the type of the entry. May be one of file, link, or dir
     * @return string
     */
    public function getType(): string;

    /**
     * Tells if the file is a directory
     * @return bool
     */
    public function isDir(): bool;

    /**
     * Tells if the file is executable
     * @return bool
     */
    public function isExecutable(): bool;

    /**
     * Tells if the object references a regular file
     * @return bool
     */
    public function isFile(): bool;

    /**
     * Tells if the file is a link
     * @return bool
     */
    public function isLink(): bool;

    /**
     * Tells if file is readable
     * @return bool
     */
    public function isReadable(): bool;

    /**
     * Tells if the entry is writable
     * @return bool
     */
    public function isWritable(): bool;

    /**
     * Returns the path to the file as a string
     * @return string
     */
    public function __toString(): string;
}
