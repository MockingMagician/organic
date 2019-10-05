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
        echo "\n";
        echo Path::clean('/one/two/../two/./three/../../two');
        echo "\n";
        echo Path::clean('../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::clean('../.././../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::clean('../././../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::clean('/../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::clean('/../../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::clean('c:\.\..\one\two\..\two\.\three\..\..\two');
        echo "\n";
        echo Path::clean(__DIR__);
        echo "\n";
        echo Path::clean(__DIR__.'/../../one/two/../two/./three/../../two');
    }
}
