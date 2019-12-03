<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\Collection;

use Faker\Factory;
use MockingMagician\Organic\Collection\InodeCollection;
use MockingMagician\Organic\Exception\CollectionValueException;
use MockingMagician\Organic\Exception\InodePathException;
use MockingMagician\Organic\Inode\Directory;
use MockingMagician\Organic\Inode\File;
use MockingMagician\Organic\PHPUnitExt\TestCase;

/**
 * @internal
 * @coversDefaultClass \MockingMagician\Organic\Collection\InodeCollection
 */
class InodeCollectionTest extends TestCase
{
    private $faker;
    private $filePath;
    private $dirPath;
    private $filePath2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->filePath = self::TEMP_DIR.'/'.$this->faker->uuid.'.'.$this->faker->fileExtension;
        $this->filePath2 = self::TEMP_DIR.'/'.$this->faker->uuid.'.'.$this->faker->fileExtension;
        $this->dirPath = self::TEMP_DIR.'/'.$this->faker->uuid;
        @\file_put_contents($this->filePath, '');
        @\file_put_contents($this->filePath2, '');
        @\mkdir($this->dirPath);
    }

    /**
     * @throws CollectionValueException
     * @throws InodePathException
     */
    public function testCreateFromPathFailIfIsNotDirOrFile(): void
    {
        static::expectException(InodePathException::class);
        InodeCollection::createFromPaths(['not-an-existing-path']);
    }

    /**
     * @throws CollectionValueException
     * @throws InodePathException
     */
    public function testCreate(): void
    {
        $inodes = InodeCollection::createFromPaths([
            $this->filePath,
            $this->dirPath,
        ]);

        foreach ($inodes as $k => $inode) {
            if (0 === $k) {
                static::assertInstanceOf(File::class, $inode);

                continue;
            }
            static::assertInstanceOf(Directory::class, $inode);
        }
    }

    /**
     * @throws CollectionValueException
     * @throws \MockingMagician\Organic\Exception\FilePathException
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
     */
    public function testAddAndRemoveAndClear(): void
    {
        $collection = new InodeCollection();
        $collection->add(new File($this->filePath));
        $collection->add(new Directory($this->dirPath));
        $collection->add(new Directory($this->dirPath));
        static::assertCount(2, $collection);
        $collection->remove(new File($this->filePath));
        $collection->remove(new File($this->filePath2));
        static::assertCount(1, $collection);
        $collection->clear();
        static::assertCount(0, $collection);
    }

    /**
     * @throws CollectionValueException
     */
    public function testConstructFail(): void
    {
        static::expectException(CollectionValueException::class);
        new InodeCollection(['string']);
    }

    /**
     * @throws CollectionValueException
     */
    public function testAddFail(): void
    {
        $collection = new InodeCollection();
        static::expectException(CollectionValueException::class);
        $collection->add('string');
    }

    /**
     * @throws CollectionValueException
     */
    public function testRemoveFail(): void
    {
        $collection = new InodeCollection();
        static::expectException(CollectionValueException::class);
        $collection->remove('string');
    }
}
