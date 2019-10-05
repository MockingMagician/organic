<?php

namespace MockingMagician\Organic\Tests;

use Faker\Factory;
use Faker\Generator;
use MockingMagician\Organic\Permission;
use MockingMagician\Organic\PermissionScope;
use PHPUnit\Framework\TestCase;

class PermissionTest extends TestCase
{
    public const TEST_TEMP_DIR = __DIR__ . '/../var/temp';

    /** @var Generator */
    private $faker;
    /** @var string */
    private $filePath;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->filePath = static::TEST_TEMP_DIR . DIRECTORY_SEPARATOR . $this->faker->uuid;
        file_put_contents($this->filePath, $this->faker->paragraph());
    }

    public function testGetMode()
    {
        $perms = new Permission(
            new PermissionScope(true, true, true),
            new PermissionScope(true, true, true),
            new PermissionScope(true, true, true)
        );

        static::assertEquals(0777, $perms->getMode());

        chmod($this->filePath, 0777);

        static::assertEquals(0777, $this->getPathMode($this->filePath));

        $perms = new Permission(
            new PermissionScope(true, true, false),
            new PermissionScope(false, false, false),
            new PermissionScope(false, false, false)
        );

        static::assertEquals(0600, $perms->getMode());

        chmod($this->filePath, 0600);

        static::assertEquals(0600, $this->getPathMode($this->filePath));

        $perms = new Permission(
            new PermissionScope(false, true, false),
            new PermissionScope(true, false, false),
            new PermissionScope(false, false, true)
        );

        static::assertEquals(0241, $perms->getMode());

        chmod($this->filePath, 0241);

        static::assertEquals(0241, $this->getPathMode($this->filePath));
    }

    public function tearDown(): void
    {
        unlink($this->filePath);
    }

    private function getPathMode(string $path): int
    {
        clearstatcache(true, $path);
        $octal = substr(sprintf('%o', fileperms($path)), -4);

        return octdec($octal);
    }
}
