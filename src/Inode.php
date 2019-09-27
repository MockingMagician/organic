<?php

namespace MockingMagician\Organic;


abstract class Inode extends \SplFileInfo
{
    public function isDirectory(): bool
    {
        return $this->isDir();
    }

    abstract public function delete(): bool;
}
