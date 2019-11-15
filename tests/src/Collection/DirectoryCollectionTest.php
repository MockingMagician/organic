<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\Collection;

use Faker\Factory;
use MockingMagician\Organic\Collection\DirectoryCollection;
use MockingMagician\Organic\PHPUnitExt\TestCase;

/**
 * @internal
 */
class DirectoryCollectionTest extends TestCase
{
    private $faker;
    private $dirPath;
    private $dirPath2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->dirPath = self::TEMP_DIR.'/'.$this->faker->uuid;
        $this->dirPath2 = self::TEMP_DIR.'/'.$this->faker->uuid;
        @\mkdir($this->dirPath);
        @\mkdir($this->dirPath2);
    }

    /**
     * @throws \MockingMagician\Organic\Exception\CollectionValueException
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
     */
    public function testCreateFromPaths(): void
    {
        static::assertInstanceOf(DirectoryCollection::class, DirectoryCollection::createFromPaths([
            $this->dirPath,
            $this->dirPath2,
        ]));
    }
}
