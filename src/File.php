<?php

namespace MockingMagician\Organic;


use MockingMagician\Organic\Exception\FileDeleteException;
use MockingMagician\Organic\Exception\FilePathException;

class File extends Inode
{
    public function __construct(string $path)
    {
        parent::__construct($path);

        if (!$this->isFile()) {
            throw new FilePathException($path);
        }
    }

    public function delete(): bool
    {
        try {
            unlink($this->getRealPath());
        } catch (\Throwable $e) {
            throw new FileDeleteException($this->getRealPath(), $e);
        }

        return true;
    }
}
