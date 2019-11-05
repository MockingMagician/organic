<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests;

use Faker\Factory;
use Faker\Generator;
use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\Inode\Base\FileInfo;
use MockingMagician\Organic\Permission\PermissionFactory;
use MockingMagician\Organic\PHPUnitExt\TestCase;

/**
 * @internal
 */
class FileInfoTest extends TestCase
{
    /** @var Generator */
    private $faker;
    /** @var string */
    private $filePath;
    /** @var FileInfo */
    private $fileInfo;
    /** @var string */
    private $fileName;

    /**
     * @throws InodePathException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->fileName = $this->faker->uuid.'.txt';
        $this->filePath = static::TEMP_DIR.\DIRECTORY_SEPARATOR.$this->fileName;
        \file_put_contents($this->filePath, $this->faker->paragraph);
        $this->fileInfo = new FileInfo($this->filePath);
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
        static::assertEquals($this->fileInfo->getObjectPath(), $fileInfoUnserialized->getObjectPath());
        static::assertEquals($this->fileInfo->getSize(), $fileInfoUnserialized->getSize());
    }

    public function testGetExtension(): void
    {
        static::assertEquals('txt', $this->fileInfo->getExtension());
    }

    public function testGetPath(): void
    {
        static::assertEquals(
            (new \SplFileInfo(self::TEMP_DIR))->getRealPath().\DIRECTORY_SEPARATOR.$this->fileName,
            $this->fileInfo->getObjectPath()
        );
    }

    public function testGetSize(): void
    {
        static::assertEquals(\filesize($this->filePath), $this->fileInfo->getSize());
    }

    /**
     * @throws \Exception
     */
    public function testGetRealPath(): void
    {
        static::assertEquals(\realpath($this->filePath), $this->fileInfo->getRealPath());
    }

    /**
     * @throws \Exception
     */
    public function testGetRealPathHasFailedCauseFileNotExistAnymore(): void
    {
        \unlink($this->filePath);
        $e = null;

        try {
            $this->fileInfo->getRealPath();
        } catch (\Throwable $e) {
        }
        static::assertInstanceOf(\Exception::class, $e);
        \file_put_contents($this->filePath, $this->faker->paragraph);
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

    /**
     * @throws InodePathException
     */
    public function testIsLink(): void
    {
        static::assertFalse($this->fileInfo->isLink());
        \symlink($this->filePath, static::TEMP_DIR.'/link');
        $fi = new FileInfo(static::TEMP_DIR.'/link');
        static::assertTrue($fi->isLink());
        \unlink($fi->getObjectPath());
    }

    public function testGetDirectoryPath(): void
    {
        static::assertEquals(\realpath(static::TEMP_DIR), $this->fileInfo->getDirectoryContainerPath());
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
