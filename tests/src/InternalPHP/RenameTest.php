<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\InternalPHP;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * This class test is only provided for explicitly describe rename function.
 *
 * @internal
 */
class RenameTest extends TestCase
{
    public const TEMP_DIR = __DIR__.'/../../var/temp';

    protected function setUp(): void
    {
        parent::setUp();
        \mkdir(static::TEMP_DIR.'/dir_one/dir_two/dir_three/dir_four/dir_five', 0777, true);
        \file_put_contents(static::TEMP_DIR.'/dir_one/dir_two/dir_three/dir_four/dir_five/file.txt', '');
    }

    protected function tearDown(): void
    {
        parent::setUp();
        $this->rmDirContent(static::TEMP_DIR);
    }

    public function testRenameDir(): void
    {
        \rename(
            static::TEMP_DIR.'/dir_one/dir_two/dir_three',
            static::TEMP_DIR.'/dir_one/dir_three'
        );

        static::assertFileExists(static::TEMP_DIR.'/dir_one/dir_three/dir_four/dir_five/file.txt');
    }

    public function testRenameFile(): void
    {
        \rename(
            static::TEMP_DIR.'/dir_one/dir_two/dir_three/dir_four/dir_five/file.txt',
            static::TEMP_DIR.'/dir_one/file.txt'
        );

        static::assertFileExists(static::TEMP_DIR.'/dir_one/file.txt');
    }

    private function rmDirContent($dir): void
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        /** @var \SplFileInfo $fileInfo */
        foreach ($files as $fileInfo) {
            $todo = ($fileInfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileInfo->getPathname());
        }
    }
}
