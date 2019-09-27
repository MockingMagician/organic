<?php

namespace MockingMagician\Organic\Tests;

use MockingMagician\Organic\Directory;
use MockingMagician\Organic\DirectoryCollection;
use MockingMagician\Organic\InodeCollection;
use PHPUnit\Framework\TestCase;

class DirectoryTest extends TestCase
{
    public const ROOT_TREE = __DIR__ . '/../env/root_tree';

    public function testIterateFile()
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(3, $directory->getFiles());
    }

    public function testIterateFileRecursively()
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(39, $directory->getRecursiveFiles());
    }

    public function testIterateDirectories()
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(3, $directory->getDirectories());
    }

    public function testIterateDirectoriesRecursively()
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(12, $directory->getRecursiveDirectories(), (function (DirectoryCollection $directoryCollection) {
            $toEcho = '';
            foreach ($directoryCollection as $value) {
                $toEcho .= $value->getRealPath()."\n";
            }

            return $toEcho;
        })($directory->getRecursiveDirectories()));
    }

    public function testIterateInode()
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(6, $directory->getInodes());
    }

    public function testIterateInodeRecursively()
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(51, $directory->getRecursiveInodes(), (function (InodeCollection $directoryCollection) {
            $toEcho = '';
            foreach ($directoryCollection as $value) {
                $toEcho .= $value->getRealPath()."\n";
            }

            return $toEcho;
        })($directory->getRecursiveInodes()));
    }
}
