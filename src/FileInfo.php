<?php

namespace MockingMagician\Organic;


use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Helper\Path;

class FileInfo implements \Serializable
{
    private $path;
    /** @var \SplFileInfo */
    private $internalSplFileInfo;

    public function __construct(string $path)
    {
        $cleanedPath = Path::clean($path);
        clearstatcache(true, $cleanedPath);
        if (!file_exists($cleanedPath)) {
            throw new FilePathException($cleanedPath);
        }

        $this->path = $cleanedPath;
        $this->internalSplFileInfo = new \SplFileInfo($this->path);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getRealPath(): string
    {
        return $this->internalSplFileInfo->getRealPath();
    }

    public function getDirectoryPath(): string
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
        return $this->internalSplFileInfo->isFile();
    }

    public function isDirectory(): bool
    {
        return $this->internalSplFileInfo->isDir();
    }

    public function isLink(): bool
    {
        return $this->internalSplFileInfo->isLink();
    }

    public function isReadable(): bool
    {
        return $this->internalSplFileInfo->isReadable();
    }

    public function isWritable(): bool
    {
        return $this->internalSplFileInfo->isWritable();
    }

    public function isExecutable(): bool
    {
        return $this->internalSplFileInfo->isExecutable();
    }

    public function getSize(): int
    {
        clearstatcache(true, $this->path);

        return $this->internalSplFileInfo->getSize();
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

    private function __getTime(string $method): \DateTimeImmutable
    {
        clearstatcache(true, $this->path);

        $time = new \DateTime();
        $time->setTimestamp($this->internalSplFileInfo->$method());

        return \DateTimeImmutable::createFromMutable($time);
    }

    public function __toString()
    {
        return $this->path;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize($this->path);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $path = unserialize($serialized);
        $this->__construct($path);
    }
}
