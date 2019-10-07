<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests;

use Faker\Factory;
use Faker\Generator;
use MockingMagician\Organic\FileObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class FileObjectTest extends TestCase
{
    public const TEMP_DIR = __DIR__.'/../../var/temp';
    private $filePath;
    private $fileName;
    private $fileExtension;
    /** @var Generator */
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
        $this->fileName = $this->faker->uuid;
        $this->fileExtension = $this->faker->fileExtension;
        $this->filePath = self::TEMP_DIR.'/'.$this->fileName.'.'.$this->fileExtension;
        parent::setUp();
        @\unlink($this->filePath);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        @\unlink($this->filePath);
    }

    /**
     * @throws \Exception
     */
    public function testCreateThenDelete(): void
    {
        $fileCreated = FileObject::create($this->filePath);
        static::assertFileExists($fileCreated);
        $fileCreated->delete();
        static::assertFileNotExists($fileCreated);
    }

    public function testGetSize(): void
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals(0, $file->getSize());
        $file->getIO()->addContent('1111');
        static::assertEquals(4, $file->getSize());
        $file->getIO()->addContent('1111');
        static::assertEquals(8, $file->getSize());
        $file->getIO()->addContent('1111');
        static::assertEquals(12, $file->getSize());
        $file->getIO()->addContent('1111');
        static::assertEquals(16, $file->getSize());
        $file->getIO()->addContent('1111');
        static::assertEquals(20, $file->getSize());
        $file->delete();
    }

    public function testGetTimes(): void
    {
        $file = FileObject::create($this->filePath);
        $startTime = $file->getChangeTime()->getTimestamp();
        \sleep(1);
        $file->getIO()->addContent('1111');
        static::assertEquals($startTime + 1, $file->getChangeTime()->getTimestamp());
        static::assertEquals($startTime + 1, $file->getModificationTime()->getTimestamp());
        static::assertEquals($startTime, $file->getAccessTime()->getTimestamp());
        \sleep(2);
        $file->getIO()->getContent();
        static::assertEquals($startTime + 1, $file->getChangeTime()->getTimestamp());
        static::assertEquals($startTime + 1, $file->getModificationTime()->getTimestamp());
        static::assertEquals($startTime + 3, $file->getAccessTime()->getTimestamp());
        $file->delete();
    }

    public function testGetBasename(): void
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals($this->fileName.'.'.$this->fileExtension, $file->getName());
    }

    public function testGetExtension(): void
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals($this->fileExtension, $file->getExtension());
    }

    public function testGetFilename(): void
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals($this->fileName, \basename($file->getName(), '.'.$file->getExtension()));
    }
}
