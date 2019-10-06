<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\Helper;

use MockingMagician\Organic\Helper\Path;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class PathTest extends TestCase
{
    public function testGetAbsolute(): void
    {
        static::assertEquals('/one/two', Path::clean('/one/two/../two/./three/../../two'));
        static::assertEquals('../one/two', Path::clean('../one/two/../two/./three/../../two'));
        static::assertEquals('../../../one/two', Path::clean('../.././../one/two/../two/./three/../../two'));
        static::assertEquals('../../one/two', Path::clean('../././../one/two/../two/./three/../../two'));
        static::assertEquals('/one/two', Path::clean('/../one/two/../two/./three/../../two'));
        static::assertEquals('/one/two', Path::clean('/../../one/two/../two/./three/../../two'));
        static::assertEquals('c:/one/two', Path::clean('c:\.\..\one\two\..\two\.\three\..\..\two'));
        static::assertEquals(__DIR__, Path::clean(__DIR__));
        static::assertEquals(
            (new \SplFileInfo((new \SplFileInfo(__DIR__))->getPath()))->getPath().'/one/two',
            Path::clean(__DIR__.'/../../one/two/../two/./three/../../two')
        );
    }
}
