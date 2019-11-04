<?php

namespace MockingMagician\Organic\Tests\FS;

use MockingMagician\Organic\FS\FSIteratorOnlyDir;

class FSIteratorOnlyDirTest extends FSIteratorTest
{
    /**
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
     */
    public function testGetIterator()
    {
        $fs = new FSIteratorOnlyDir(static::TEMP_DIR);
        static::assertCount(1, $fs->getIterator());
    }
}
