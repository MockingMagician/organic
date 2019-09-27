<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests;

use MockingMagician\Organic\Collection\DirectoryCollection;
use MockingMagician\Organic\Collection\InodeCollection;
use MockingMagician\Organic\Directory;
use MockingMagician\Organic\Inode;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DirectoryTest extends TestCase
{
    public const ROOT_TREE = __DIR__.'/../env/root_tree';

    public function testIterateFile(): void
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(3, $directory->getFiles());
    }

    public function testIterateFileRecursively(): void
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(39, $directory->getRecursiveFiles());
    }

    public function testIterateDirectories(): void
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(3, $directory->getDirectories());
    }

    public function testIterateDirectoriesRecursively(): void
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(12, $directory->getRecursiveDirectories(), (function (DirectoryCollection $directoryCollection) {
            $toEcho = '';
            /** @var Directory $value */
            foreach ($directoryCollection as $value) {
                $toEcho .= $value->getRealPath()."\n";
            }

            return $toEcho;
        })($directory->getRecursiveDirectories()));
    }

    public function testIterateInode(): void
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(6, $directory->getInodes());
    }

    public function testIterateInodeRecursively(): void
    {
        $directory = new Directory(self::ROOT_TREE);
        static::assertCount(51, $directory->getRecursiveInodes(), (function (InodeCollection $directoryCollection) {
            $toEcho = '';
            /** @var Inode $value */
            foreach ($directoryCollection as $value) {
                $toEcho .= $value->getRealPath()."\n";
            }

            return $toEcho;
        })($directory->getRecursiveInodes()));
    }

    public function testCreateSubDirectory(): void
    {
        $directory = new Directory(self::ROOT_TREE);
        $freshlyCreatedDirectory = $directory->createSubDirectory('freshly_created');
        static::assertCount(4, $directory->getDirectories());
        $freshlyCreatedDirectory->delete();
        static::assertCount(3, $directory->getDirectories());
    }
}
