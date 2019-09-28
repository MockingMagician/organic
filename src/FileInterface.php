<?php

namespace MockingMagician\Organic;


interface FileInterface extends InodeInterface
{
    /**
     * Get an interface for read or write in file
     * @param string $openMode
     * @return ReadWriteFileInterface
     */
    public function getReaderWriter(string $openMode = "r"): ReadWriteFileInterface;
}
