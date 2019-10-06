<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests;

use Faker\Factory;
use Faker\Generator;
use MockingMagician\Organic\FileInfo;
use MockingMagician\Organic\PermissionFactory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class FileInfoTest extends TestCase
{
    public const TEMP_DIR = __DIR__.'/../var/temp';
    /** @var Generator */
    private $faker;
    /** @var string */
    private $filePath;
    /** @var FileInfo */
    private $fileInfo;
    /** @var string */
    private $fileName;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->fileName = $this->faker->uuid.'.txt';
        $this->filePath = static::TEMP_DIR.\DIRECTORY_SEPARATOR.$this->fileName;
        \file_put_contents($this->filePath, $this->faker->paragraph);
        $this->fileInfo = new FileInfo($this->filePath);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \unlink($this->filePath);
    }

    public function testUnserialize(): void
    {
        static::assertIsString(\serialize($this->fileInfo));
    }

    public function testSerialize(): void
    {
        /** @var FileInfo $fileInfo */
        $fileInfoUnserialized = \unserialize(\serialize($this->fileInfo));
        static::assertInstanceOf(FileInfo::class, $fileInfoUnserialized);
        static::assertEquals($this->fileInfo->getPath(), $fileInfoUnserialized->getPath());
        static::assertEquals($this->fileInfo->getSize(), $fileInfoUnserialized->getSize());
    }

    public function testGetExtension(): void
    {
        static::assertEquals('txt', $this->fileInfo->getExtension());
    }

    public function testGetPath(): void
    {
        static::assertEquals(
            (new \SplFileInfo(__DIR__))->getPath().'/var/temp/'.$this->fileName,
            $this->fileInfo->getPath()
        );
    }

    public function testGetSize(): void
    {
        static::assertEquals(\filesize($this->filePath), $this->fileInfo->getSize());
    }

    public function testGetRealPath(): void
    {
        static::assertEquals(\realpath($this->filePath), $this->fileInfo->getRealPath());
    }

    public function testGetChangeTime(): void
    {
        static::assertEquals(\filectime($this->filePath), $this->fileInfo->getChangeTime()->getTimestamp());
    }

    public function testGetAccessTime(): void
    {
        static::assertEquals(\fileatime($this->filePath), $this->fileInfo->getAccessTime()->getTimestamp());
    }

    public function testGetModificationTime(): void
    {
        static::assertEquals(\filemtime($this->filePath), $this->fileInfo->getModificationTime()->getTimestamp());
    }

    public function testIsLink(): void
    {
        static::assertFalse($this->fileInfo->isLink());
        \symlink($this->filePath, static::TEMP_DIR.'/link');
        $fi = new FileInfo(static::TEMP_DIR.'/link');
        static::assertTrue($fi->isLink());
        \unlink($fi->getPath());
    }

    public function testGetDirectoryPath(): void
    {
        static::assertEquals(\realpath(static::TEMP_DIR), $this->fileInfo->getDirectoryPath());
    }

    public function testIsDirectory(): void
    {
        static::assertFalse($this->fileInfo->isDirectory());
    }

    public function testGetName(): void
    {
        static::assertEquals($this->fileName, $this->fileInfo->getName());
    }

    public function testIsReadable(): void
    {
        static::assertTrue($this->fileInfo->isReadable());
    }

    public function testToString(): void
    {
        static::assertEquals($this->fileName, $this->fileInfo->getName());
    }

    public function testIsWritable(): void
    {
        static::assertTrue($this->fileInfo->isWritable());
    }

    public function testGetPermissions(): void
    {
        static::assertEquals(
            PermissionFactory::defaultFile(),
            $this->fileInfo->getPermissions()
        );
    }

    public function testIsFile(): void
    {
        static::assertTrue($this->fileInfo->isFile());
    }

    public function testIsExecutable(): void
    {
        static::assertFalse($this->fileInfo->isExecutable());
    }
}
