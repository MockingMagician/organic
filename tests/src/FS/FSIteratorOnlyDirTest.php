<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\FS;

use MockingMagician\Organic\Exception\DirectoryPathException;
use MockingMagician\Organic\FS\FSIteratorOnlyDir;

/**
 * @internal
 * @coversDefaultClass \MockingMagician\Organic\FS\FSIteratorOnlyDir
 */
class FSIteratorOnlyDirTest extends FSIteratorTest
{
    /**
     * @throws DirectoryPathException
     */
    public function testGetIterator(): void
    {
        $fs = new FSIteratorOnlyDir(self::TEMP_DIR);
        static::assertCount(1, $fs->getIterator());
    }
}
