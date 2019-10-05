<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests;

use Faker\Factory;
use Faker\Generator;
use MockingMagician\Organic\Exception\FileLinkException;
use MockingMagician\Organic\FileObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class FileObjectTest extends TestCase
{
    public const VAR_DIR = __DIR__.'/../../var';
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
        $this->filePath = self::VAR_DIR.'/'.$this->fileName.'.'.$this->fileExtension;
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

    public function testGetSise(): void
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
        $startTime = $file->getCTime()->getTimestamp();
        \sleep(1);
        $file->getIO()->addContent('1111');
        static::assertEquals($startTime + 1, $file->getCTime()->getTimestamp());
        static::assertEquals($startTime + 1, $file->getMTime()->getTimestamp());
        static::assertEquals($startTime, $file->getATime()->getTimestamp());
        \sleep(2);
        $file->getIO()->getContent();
        static::assertEquals($startTime + 1, $file->getCTime()->getTimestamp());
        static::assertEquals($startTime + 1, $file->getMTime()->getTimestamp());
        static::assertEquals($startTime + 3, $file->getATime()->getTimestamp());
        $file->delete();
    }

    public function testGetBasename(): void
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals($this->fileName.'.'.$this->fileExtension, $file->getBasename());
    }

    public function testGetExtension(): void
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals($this->fileExtension, $file->getExtension());
    }

    public function testGetFilename(): void
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals($this->fileName, $file->getFilename());
    }

    public function testGetGroup(): void
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals(\getmygid(), $file->getGroup());
    }

    public function testGetInode(): void
    {
        $file = FileObject::create($this->filePath);
        static::assertIsInt($file->getInode());
    }

    public function testGetLinkTarget(): void
    {
        $file = FileObject::create($this->filePath);
        static::expectException(FileLinkException::class);
        $file->getLinkTarget();
    }

    public function testCreateLink(): void
    {
        $file = FileObject::create($this->filePath);
        $linkPath = self::VAR_DIR.'/'.$this->faker->uuid;
        $link = $file->createLink($linkPath);
        static::assertEquals($linkPath, $link->getRealPath());
        @\unlink($linkPath);
    }

    public function testGetOwner(): void
    {
    }

    public function testGetPath(): void
    {
    }

    public function testGetPathname(): void
    {
    }

    public function testGetPerms(): void
    {
    }

    public function testGetRealPath(): void
    {
    }

    public function testGetSize(): void
    {
    }
}
