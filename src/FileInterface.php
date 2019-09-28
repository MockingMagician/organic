<?php

namespace MockingMagician\Organic;


interface FileInterface extends InodeInterface
{
    /**
     * Get an interface for read or write in file
     * @return ReadWriteFileInterface
     */
    public function getRW(): ReadWriteFileInterface;
}
