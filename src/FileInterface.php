<?php

namespace MockingMagician\Organic;


interface FileInterface extends InodeInterface
{
    /**
     * Get an interface for read or write in file
     * @param string $openMode
     * @return IOFileInterface
     */
    public function getIO(string $openMode = "r"): IOFileInterface;
}
