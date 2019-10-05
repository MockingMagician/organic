<?php

namespace MockingMagician\Organic;


class PermissionScope
{
    private const EXECUTE = 1;
    private const WRITE = 2;
    private const READ = 4;

    private $read;
    private $write;
    private $execute;

    public function __construct(bool $read, bool $write, bool $execute)
    {
        $this->read = $read;
        $this->write = $write;
        $this->execute = $execute;
    }

    public function getP(): int
    {
        $p = 0;

        if ($this->execute) {
            $p += static::EXECUTE;
        }

        if ($this->write) {
            $p += static::WRITE;
        }

        if ($this->read) {
            $p += static::READ;
        }

        return $p;
    }
}
