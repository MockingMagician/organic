<?php

namespace MockingMagician\Organic;


interface DirectoryInterface extends InodeInterface
{
    public function getInodes();
    public function getFiles();
    public function getDirectories();
}
