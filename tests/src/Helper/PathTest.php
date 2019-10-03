<?php

namespace MockingMagician\Organic\Tests\Helper;

use MockingMagician\Organic\Helper\Path;
use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{

    public function testGetAbsolute()
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
