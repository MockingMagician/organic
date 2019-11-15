<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\InternalPHP;

use MockingMagician\Organic\PHPUnitExt\TestCase;

/**
 * This class test is only provided for explicitly describe rename function.
 *
 * @internal
 */
class RenameTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        \mkdir(static::TEMP_DIR.'/dir_one/dir_two/dir_three/dir_four/dir_five', 0777, true);
        \file_put_contents(static::TEMP_DIR.'/dir_one/dir_two/dir_three/dir_four/dir_five/file.txt', '');
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
}
