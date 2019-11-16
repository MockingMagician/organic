<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\Inode;

use Faker\Factory;
use Faker\Generator;
use MockingMagician\Organic\Exception\FileAlreadyExistException;
use MockingMagician\Organic\Exception\FileCreateException;
use MockingMagician\Organic\Exception\FileDeleteException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Inode\File;
use MockingMagician\Organic\PHPUnitExt\TestCase;

/**
 * @internal
 */
class FileTest extends TestCase
{
    private $filePath;
    private $fileName;
    private $fileExtension;
    /** @var Generator */
    private $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->fileName = $this->faker->uuid;
        $this->fileExtension = $this->faker->fileExtension;
        $this->filePath = self::TEMP_DIR.\DIRECTORY_SEPARATOR.$this->fileName.'.'.$this->fileExtension;
        @\unlink($this->filePath);
    }

    /**
     * @throws \Exception
     */
    public function testCreateThenDelete(): void
    {
        $fileCreated = File::create($this->filePath);
        static::assertFileExists($fileCreated);
        $fileCreated->delete();
        static::assertFileNotExists($fileCreated);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteNotExistingFileThrowAnException(): void
    {
        $fileCreated = File::create($this->filePath);
        static::assertFileExists($fileCreated);
        \unlink($this->filePath);
        static::assertFileNotExists($fileCreated);
        static::expectException(FileDeleteException::class);
        $fileCreated->delete();
    }

    /**
     * @throws FileAlreadyExistException
     * @throws \MockingMagician\Organic\Exception\FilePathException
     * @throws \Exception
     */
    public function testGetSize(): void
    {
        $file = File::create($this->filePath);
        static::assertEquals(0, $file->getSize()->bytes());
        $file->getIO()->addContent('1111');
        static::assertEquals(4, $file->getSize()->bytes());
        $file->getIO()->addContent('1111');
        static::assertEquals(8, $file->getSize()->bytes());
        $file->getIO()->addContent('1111');
        static::assertEquals(12, $file->getSize()->bytes());
        $file->getIO()->addContent('1111');
        static::assertEquals(16, $file->getSize()->bytes());
        $file->getIO()->addContent('1111');
        static::assertEquals(20, $file->getSize()->bytes());
        $file->delete();
    }

    /**
     * @retry 5
     *
     * @throws FileAlreadyExistException
     * @throws \MockingMagician\Organic\Exception\FilePathException
     * @throws \Exception
     */
    public function testGetTimes(): void
    {
        if (0 === \mb_strrpos(PHP_OS, 'WIN')) {
            static::markTestSkipped('This tests make sense only for POSIX');
        }

        $file = File::create($this->filePath);
        $startTime = $file->getChangeTime()->getTimestamp();
        \usleep(1200000);
        $file->getIO()->addContent('1111');
        static::assertEquals($startTime + 1, $file->getChangeTime()->getTimestamp());
        static::assertEquals($startTime + 1, $file->getModificationTime()->getTimestamp());
        static::assertEquals($startTime, $file->getAccessTime()->getTimestamp());
        \usleep(2200000);
        $file->getIO()->getContent();
        static::assertEquals($startTime + 1, $file->getChangeTime()->getTimestamp());
        static::assertEquals($startTime + 1, $file->getModificationTime()->getTimestamp());
        static::assertEquals($startTime + 3, $file->getAccessTime()->getTimestamp());
        $file->delete();
    }

    /**
     * @throws FileAlreadyExistException
     * @throws FileCreateException
     * @throws FilePathException
     */
    public function testGetBasename(): void
    {
        $file = File::create($this->filePath);
        static::assertEquals($this->fileName.'.'.$this->fileExtension, $file->getName());
    }

    /**
     * @throws FileAlreadyExistException
     * @throws FileCreateException
     * @throws FilePathException
     */
    public function testGetExtension(): void
    {
        $file = File::create($this->filePath);
        static::assertEquals($this->fileExtension, $file->getExtension());
    }

    /**
     * @throws FileAlreadyExistException
     * @throws FileCreateException
     * @throws FilePathException
     */
    public function testGetFilename(): void
    {
        $file = File::create($this->filePath);
        static::assertEquals($this->fileName, \basename($file->getName(), '.'.$file->getExtension()));
    }

    /**
     * @throws FileAlreadyExistException
     * @throws FileCreateException
     * @throws FilePathException
     */
    public function testCreateAnExistingThrowAnException(): void
    {
        File::create($this->filePath);
        static::expectException(FileAlreadyExistException::class);
        File::create($this->filePath);
    }

    /**
     * @throws FileAlreadyExistException
     * @throws FileCreateException
     * @throws FilePathException
     */
    public function testCreateThrowAnExceptionOnFilePutContentsFail(): void
    {
        static::expectException(FileCreateException::class);
        File::create($this->filePath.'/that/is-not-valid-path');
    }
}
