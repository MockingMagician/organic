<?php

namespace MockingMagician\Organic\Tests\FS;

use MockingMagician\Organic\FS\FSIteratorOnlyFiles;

class FSIteratorOnlyFileTest extends FSIteratorTest
{
    /**
     * @throws \MockingMagician\Organic\Exception\DirectoryPathException
     */
    public function testGetIterator()
    {
        $fs = new FSIteratorOnlyFiles(static::TEMP_DIR);
        static::assertCount(2, $fs->getIterator());
    }
}
