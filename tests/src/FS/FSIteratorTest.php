<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\FS;

use Faker\Factory;
use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\FS\FSIterator;
use MockingMagician\Organic\PHPUnitExt\TestCase;

/**
 * @internal
 */
class FSIteratorTest extends TestCase
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
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
     */
    public function testGetIterator(): void
    {
        $fs = new FSIterator(static::TEMP_DIR);
        static::assertCount(3, $fs->getIterator());
    }

    /**
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
     */
    public function testNewFSIteratorFailCauseNotDirectoryPath(): void
    {
        static::expectException(DirectoryPathException::class);
        new FSIterator(static::TEMP_DIR.'not-exist');
    }
}
