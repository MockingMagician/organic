<?php

namespace MockingMagician\Organic\Tests;

use Faker\Factory;
use Faker\Generator;
use MockingMagician\Organic\Exception\FileLinkException;
use MockingMagician\Organic\FileObject;
use PHPUnit\Framework\TestCase;


class FileObjectTest extends TestCase
{
    public const VAR_DIR = __DIR__ . '/../../var';
    private $filePath;
    private $fileName;
    private $fileExtension;
    /** @var Generator */
    private $faker;

    public function setUp(): void
    {
        $this->faker = Factory::create();
        $this->fileName = $this->faker->uuid;
        $this->fileExtension = $this->faker->fileExtension;
        $this->filePath = self::VAR_DIR.'/'.$this->fileName.'.'.$this->fileExtension;
        parent::setUp();
        @unlink($this->filePath);
    }

    /**
     * @throws \Exception
     */
    public function testCreateThenDelete()
    {
        $fileCreated = FileObject::create($this->filePath);
        static::assertFileExists($fileCreated);
        $fileCreated->delete();
        static::assertFileNotExists($fileCreated);
    }

    public function testGetSise()
    {
        $file = FileObject::create($this->filePath);
        self::assertEquals(0, $file->getSize());
        $file->getIO()->addContent('1111');
        self::assertEquals(4, $file->getSize());
        $file->getIO()->addContent('1111');
        self::assertEquals(8, $file->getSize());
        $file->getIO()->addContent('1111');
        self::assertEquals(12, $file->getSize());
        $file->getIO()->addContent('1111');
        self::assertEquals(16, $file->getSize());
        $file->getIO()->addContent('1111');
        self::assertEquals(20, $file->getSize());
        $file->delete();
    }

    public function testGetTimes()
    {
        $file = FileObject::create($this->filePath);
        $startTime = $file->getCTime()->getTimestamp();
        sleep(1);
        $file->getIO()->addContent('1111');
        self::assertEquals($startTime + 1, $file->getCTime()->getTimestamp());
        self::assertEquals($startTime + 1, $file->getMTime()->getTimestamp());
        self::assertEquals($startTime, $file->getATime()->getTimestamp());
        sleep(2);
        $file->getIO()->getContent();
        self::assertEquals($startTime + 1, $file->getCTime()->getTimestamp());
        self::assertEquals($startTime + 1, $file->getMTime()->getTimestamp());
        self::assertEquals($startTime + 3, $file->getATime()->getTimestamp());
        $file->delete();
    }

    public function testGetBasename()
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals($this->fileName.'.'.$this->fileExtension, $file->getBasename());
    }

    public function testGetExtension()
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals($this->fileExtension, $file->getExtension());
    }

    public function testGetFilename()
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals($this->fileName, $file->getFilename());
    }

    public function testGetGroup()
    {
        $file = FileObject::create($this->filePath);
        static::assertEquals(getmygid(), $file->getGroup());
    }

    public function testGetInode()
    {
        $file = FileObject::create($this->filePath);
        static::assertIsInt($file->getInode());
    }

    public function testGetLinkTarget()
    {
        $file = FileObject::create($this->filePath);
        static::expectException(FileLinkException::class);
        $file->getLinkTarget();
    }

    public function testCreateLink()
    {
        $file = FileObject::create($this->filePath);
        $linkPath = self::VAR_DIR.'/'.$this->faker->uuid;
        $link = $file->createLink($linkPath);
        static::assertEquals($linkPath, $link->getRealPath());
        @unlink($linkPath);
    }

    public function testGetOwner()
    {

    }

    public function testGetPath()
    {

    }

    public function testGetPathname()
    {

    }

    public function testGetPerms()
    {

    }

    public function testGetRealPath()
    {

    }

    public function testGetSize()
    {

    }

    public function tearDown(): void
    {
        parent::tearDown();
        @unlink($this->filePath);
    }
}
