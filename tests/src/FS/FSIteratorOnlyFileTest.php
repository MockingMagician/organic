<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\FS;

use MockingMagician\Organic\FS\FSIteratorOnlyFiles;

/**
 * @internal
 */
class FSIteratorOnlyFileTest extends FSIteratorTest
{
    /**
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
     */
    public function testGetIterator(): void
    {
        $fs = new FSIteratorOnlyFiles(static::TEMP_DIR);
        static::assertCount(2, $fs->getIterator());
    }
}
