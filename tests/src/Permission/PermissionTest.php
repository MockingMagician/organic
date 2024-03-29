<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\Permission;

use Faker\Factory;
use Faker\Generator;
use MockingMagician\Organic\Permission\Permission;
use MockingMagician\Organic\Permission\PermissionScope;
use MockingMagician\Organic\PHPUnitExt\TestCase;

/**
 * @internal
 * @coversDefaultClass \MockingMagician\Organic\Permission\Permission
 */
class PermissionTest extends TestCase
{
    /** @var Generator */
    private $faker;
    /** @var string */
    private $filePath;

    protected function setUp(): void
    {
        if (0 === \mb_strrpos(PHP_OS, 'WIN')) {
            static::markTestSkipped('This tests make sense only for POSIX');
        }

        parent::setUp();
        $this->faker = Factory::create();
        $this->filePath = static::TEMP_DIR.\DIRECTORY_SEPARATOR.$this->faker->uuid;
        \file_put_contents($this->filePath, $this->faker->paragraph());
    }

    public function testGetMode(): void
    {
        $perms = new Permission(
            new PermissionScope(true, true, true),
            new PermissionScope(true, true, true),
            new PermissionScope(true, true, true)
        );

        static::assertEquals(0777, $perms->getMode());

        \chmod($this->filePath, 0777);

        static::assertEquals(0777, $this->getPathMode($this->filePath));

        $perms = new Permission(
            new PermissionScope(true, true, false),
            new PermissionScope(false, false, false),
            new PermissionScope(false, false, false)
        );

        static::assertEquals(0600, $perms->getMode());

        \chmod($this->filePath, 0600);

        static::assertEquals(0600, $this->getPathMode($this->filePath));

        $perms = new Permission(
            new PermissionScope(false, true, false),
            new PermissionScope(true, false, false),
            new PermissionScope(false, false, true)
        );

        static::assertEquals(0241, $perms->getMode());

        \chmod($this->filePath, 0241);

        static::assertEquals(0241, $this->getPathMode($this->filePath));
    }

    private function getPathMode(string $path): int
    {
        \clearstatcache(true, $path);
        $octal = \substr(\sprintf('%o', \fileperms($path)), -4);

        return \octdec($octal);
    }
}
