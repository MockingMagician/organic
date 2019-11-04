<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\Collection;

use Faker\Factory;
use MockingMagician\Organic\Collection\FileCollection;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class FileCollectionTest extends TestCase
{
    public const TEMP_DIR = __DIR__.'/../../var/temp';

    private $faker;
    private $filePath;
    private $filePath2;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
        $this->filePath = self::TEMP_DIR.'/'.$this->faker->uuid.'.'.$this->faker->fileExtension;
        $this->filePath2 = self::TEMP_DIR.'/'.$this->faker->uuid.'.'.$this->faker->fileExtension;
        parent::setUp();
        @\file_put_contents($this->filePath, '');
        @\file_put_contents($this->filePath2, '');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        @\unlink($this->filePath);
        @\unlink($this->filePath2);
    }

    /**
     * @throws \MockingMagician\Organic\Exception\CollectionValueException
     * @throws \MockingMagician\Organic\Exception\FilePathException
     */
    public function testCreateFromPaths(): void
    {
        static::assertInstanceOf(FileCollection::class, FileCollection::createFromPaths([
            $this->filePath,
            $this->filePath2,
        ]));
    }
}
