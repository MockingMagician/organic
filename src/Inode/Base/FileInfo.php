<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Inode\Base;

use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\Helper\Path;
use MockingMagician\Organic\Permission\Permission;
use MockingMagician\Organic\Permission\PermissionFactory;
use MockingMagician\Organic\Size\Size;

class FileInfo implements \Serializable
{
    private $path;
    /** @var \SplFileInfo */
    private $internalSplFileInfo;

    /**
     * FileInfo constructor.
     *
     * @throws InodePathException
     */
    public function __construct(string $path)
    {
        $cleanedPath = Path::clean($path);
        \clearstatcache(true, $cleanedPath);
        if (!\file_exists($cleanedPath)) {
            throw new InodePathException($cleanedPath);
        }

        $this->path = $cleanedPath;
        $this->internalSplFileInfo = new \SplFileInfo($this->path);
    }

    private function __getTime(string $method): \DateTimeImmutable
    {
        \clearstatcache(true, $this->path);

        $time = new \DateTime();
        $time->setTimezone(new \DateTimeZone('UTC'));
        $time->setTimestamp($this->internalSplFileInfo->{$method}());

        return \DateTimeImmutable::createFromMutable($time);
    }

    public function __toString()
    {
        return $this->path;
    }

    public function getObjectPath(): string
    {
        return $this->path;
    }

    /**
     * @throws \Exception
     */
    public function getRealPath(): string
    {
        \clearstatcache(true, $this->path);
        $realPath = $this->internalSplFileInfo->getRealPath();

        if (false === $realPath) {
            throw new \Exception('Getting realPath has failed');
        }

        return $realPath;
    }

    public function getDirectoryContainerPath(): string
    {
        return $this->internalSplFileInfo->getPath();
    }

    public function getName(): string
    {
        return $this->internalSplFileInfo->getFilename();
    }

    public function getExtension(): string
    {
        return $this->internalSplFileInfo->getExtension();
    }

    public function isFile(): bool
    {
        \clearstatcache(true, $this->path);

        return $this->internalSplFileInfo->isFile();
    }

    public function isDirectory(): bool
    {
        \clearstatcache(true, $this->path);

        return $this->internalSplFileInfo->isDir();
    }

    public function isLink(): bool
    {
        \clearstatcache(true, $this->path);

        return $this->internalSplFileInfo->isLink();
    }

    public function isReadable(): bool
    {
        \clearstatcache(true, $this->path);

        return $this->internalSplFileInfo->isReadable();
    }

    public function isWritable(): bool
    {
        \clearstatcache(true, $this->path);

        return $this->internalSplFileInfo->isWritable();
    }

    public function isExecutable(): bool
    {
        \clearstatcache(true, $this->path);

        return $this->internalSplFileInfo->isExecutable();
    }

    public function getSize(): Size
    {
        \clearstatcache(true, $this->path);

        return new Size($this->internalSplFileInfo->getSize());
    }

    public function getAccessTime(): \DateTimeImmutable
    {
        return $this->__getTime('getATime');
    }

    public function getModificationTime(): \DateTimeImmutable
    {
        return $this->__getTime('getMTime');
    }

    public function getChangeTime(): \DateTimeImmutable
    {
        return $this->__getTime('getCTime');
    }

    public function getPermissions(): Permission
    {
        \clearstatcache(true, $this->path);
        $octal = \substr(\sprintf('%o', $this->internalSplFileInfo->getPerms()), -4);

        return PermissionFactory::createFromMode(\octdec($octal));
    }

    /**
     * String representation of object.
     *
     * @see http://php.net/manual/en/serializable.serialize.php
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return \serialize($this->path);
    }

    /**
     * Constructs the object.
     *
     * @see http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized the string representation of the object
     *
     * @throws InodePathException
     */
    public function unserialize($serialized): void
    {
        $path = \unserialize($serialized);
        $this->__construct($path);
    }
}
