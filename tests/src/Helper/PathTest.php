<?php

namespace MockingMagician\Organic\Tests\Helper;

use MockingMagician\Organic\Helper\Path;
use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{

    public function testGetAbsolute()
    {
        echo "\n";
        echo Path::getAbsolute('/one/two/../two/./three/../../two');
        echo "\n";
        echo Path::getAbsolute('../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::getAbsolute('../.././../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::getAbsolute('../././../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::getAbsolute('/../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::getAbsolute('/../../one/two/../two/./three/../../two');
        echo "\n";
        echo Path::getAbsolute('c:\.\..\one\two\..\two\.\three\..\..\two');
        echo "\n";
        echo Path::getAbsolute(__DIR__);
        echo "\n";
        echo Path::getAbsolute(__DIR__.'/../../one/two/../two/./three/../../two');
    }
}
