<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\Inode;

use Faker\Factory;
use MockingMagician\Organic\Exception\CollectionValueException;
use MockingMagician\Organic\Exception\DirectoryCreateException;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\Exception\FilePathException;
use MockingMagician\Organic\Exception\InodeMoveToException;
use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\Helper\Path;
use MockingMagician\Organic\Inode\Directory;
use MockingMagician\Organic\Permission\Permission;
use MockingMagician\Organic\Permission\PermissionFactory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DirectoryTest extends TestCase
{
    public const TEMP_DIR = __DIR__.'/../../var/temp';
    private $faker;
    private $filePath;
    private $dirPath;
    private $filePath2;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
        $this->filePath = self::TEMP_DIR.'/'.$this->faker->uuid.'.'.$this->faker->fileExtension;
        $this->filePath2 = self::TEMP_DIR.'/'.$this->faker->uuid.'.'.$this->faker->fileExtension;
        $this->dirPath = self::TEMP_DIR.'/'.$this->faker->uuid;
        parent::setUp();
        @\file_put_contents($this->filePath, '');
        @\file_put_contents($this->filePath2, '');
        @\mkdir($this->dirPath);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        @\unlink($this->filePath);
        @\unlink($this->filePath2);
        @\rmdir($this->dirPath);
    }

    /**
     * @throws CollectionValueException
     * @throws DirectoryPathException
     * @throws InodePathException
     */
    public function testGetInodes(): void
    {
        $directory = new Directory(static::TEMP_DIR);
        static::assertCount(3, $directory->getInodes());
    }

    /**
     * @throws CollectionValueException
     * @throws DirectoryPathException
     * @throws FilePathException
     */
    public function testGetFiles(): void
    {
        $directory = new Directory(static::TEMP_DIR);
        static::assertCount(2, $directory->getFiles());
    }

    /**
     * @throws CollectionValueException
     * @throws DirectoryPathException
     */
    public function testGetDirectories(): void
    {
        $directory = new Directory(static::TEMP_DIR);
        static::assertCount(1, $directory->getDirectories());
    }

    /**
     * @throws DirectoryPathException
     */
    public function testDirectoryFailCauseItIsNotAValidPath(): void
    {
        static::expectException(DirectoryPathException::class);
        new Directory($this->filePath);
    }

    /**
     * @throws DirectoryPathException
     * @throws DirectoryCreateException
     */
    public function testCreateDirectory(): void
    {
        $directory = Directory::create(static::TEMP_DIR.DIRECTORY_SEPARATOR.'new-dir');
        self::assertEquals(PermissionFactory::defaultDirectory(), $directory->getPermissions());
        @\rmdir(static::TEMP_DIR.DIRECTORY_SEPARATOR.'new-dir');

        $permission = PermissionFactory::createFromMode(0741);
        $directory = Directory::create(static::TEMP_DIR.DIRECTORY_SEPARATOR.'new-dir', $permission);
        self::assertEquals($permission, $directory->getPermissions());
        @\rmdir(static::TEMP_DIR.DIRECTORY_SEPARATOR.'new-dir');
    }

    /**
     * @throws DirectoryPathException
     * @throws DirectoryCreateException
     */
    public function testCreateDirectoryFailCauseInvalidPath(): void
    {
        static::expectException(DirectoryCreateException::class);
        Directory::create(
            static::TEMP_DIR.DIRECTORY_SEPARATOR.'new-dir'.DIRECTORY_SEPARATOR.'sub-dir',
            PermissionFactory::defaultDirectory(),
            false
        );
    }

    /**
     * @throws DirectoryPathException
     * @throws DirectoryCreateException
     */
    public function testDeleteDirectory(): void
    {
        static::expectException(DirectoryCreateException::class);
        Directory::create(
            static::TEMP_DIR.DIRECTORY_SEPARATOR.'new-dir'.DIRECTORY_SEPARATOR.'sub-dir',
            PermissionFactory::defaultDirectory(),
            false
        );
    }

    /**
     * @throws DirectoryPathException
     */
    public function testDelete(): void
    {
        mkdir($this->dirPath.DIRECTORY_SEPARATOR.'dir2');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'file1', '');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'file2', '');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'file3', '');
        mkdir($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'dir3');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'dir3'.DIRECTORY_SEPARATOR.'file1', '');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'dir3'.DIRECTORY_SEPARATOR.'file2', '');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'dir3'.DIRECTORY_SEPARATOR.'file3', '');

        $directory = new Directory($this->dirPath);
        static::assertEquals(false, $directory->delete());
        static::assertFileExists($this->dirPath);

        static::assertEquals(true, $directory->delete(true));
        static::assertFileNotExists($this->dirPath);
    }

    /**
     * @throws DirectoryPathException
     * @throws InodePathException
     * @throws InodeMoveToException
     */
    public function testMoveTo()
    {
        mkdir($this->dirPath.DIRECTORY_SEPARATOR.'dir2', 0777, true);
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'file1', '');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'file2', '');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'file3', '');
        mkdir($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'dir3');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'dir3'.DIRECTORY_SEPARATOR.'file1', '');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'dir3'.DIRECTORY_SEPARATOR.'file2', '');
        file_put_contents($this->dirPath.DIRECTORY_SEPARATOR.'dir2'.DIRECTORY_SEPARATOR.'dir3'.DIRECTORY_SEPARATOR.'file3', '');

        $directory = new Directory($this->dirPath);
        $directory->moveTo(static::TEMP_DIR.DIRECTORY_SEPARATOR.'moved_dir');
        static::assertFileExists(static::TEMP_DIR.DIRECTORY_SEPARATOR.'moved_dir');
        static::assertEquals(
            Path::clean(static::TEMP_DIR.DIRECTORY_SEPARATOR.'moved_dir'),
            $directory->getObjectPath()
        );
    }

    /**
     * @throws DirectoryPathException
     * @throws InodePathException
     * @throws InodeMoveToException
     */
    public function testMoveToFailedCauseFileWithSameNameAlreadyExist()
    {
        $this->dirPath = static::TEMP_DIR.DIRECTORY_SEPARATOR.'moved_dir';
        file_put_contents($this->dirPath.'/../same-name', '');
        $directory = new Directory($this->dirPath);
        static::expectException(InodeMoveToException::class);
        $directory->moveTo($this->dirPath.'/../same-name');
    }

    /**
     * @throws DirectoryPathException
     * @throws InodePathException
     * @throws InodeMoveToException
     */
    public function testMoveToFailedCauseCanNotMoveToPath()
    {
        $this->dirPath = static::TEMP_DIR.DIRECTORY_SEPARATOR.'moved_dir';
        $directory = new Directory($this->dirPath);
        static::expectException(InodeMoveToException::class);
        $directory->moveTo($this->dirPath.'/../another/that-not-exist/with-long-path');
    }
}
