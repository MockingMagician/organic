<?php

namespace MockingMagician\Organic\Helper;


use MockingMagician\Organic\Exception\DirectoryPathException;
use Traversable;

class FSIterator implements \IteratorAggregate
{
    private $path;

    public function __construct(string $path)
    {
        if (!is_dir($path)) {
            throw new DirectoryPathException($path);
        }
        $this->path = $path;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->scanDir());
    }

    protected function scanDir()
    {
        return array_diff(scandir($this->path), array('..', '.'));
    }
}
