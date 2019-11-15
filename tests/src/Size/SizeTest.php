<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\Size;

use MockingMagician\Organic\Size\Size;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class SizeTest extends TestCase
{
    /** @var Size */
    private $size;

    protected function setUp(): void
    {
        parent::setUp();
        $this->size = new Size(1073741824);
    }

    public function testBits(): void
    {
        static::assertEquals(8589934592, $this->size->bits());
    }

    public function testBytes(): void
    {
        static::assertEquals(1073741824, $this->size->bytes());
    }

    public function testKiloBytes(): void
    {
        static::assertEquals(1073742, $this->size->kiloBytes());
    }

    public function testMegaBytes(): void
    {
        static::assertEquals(1074, $this->size->megaBytes());
    }

    public function testGigaBytes(): void
    {
        static::assertEquals(1.074, $this->size->gigaBytes(3));
    }

    public function testTeraBytes(): void
    {
        static::assertEquals(0.00107, $this->size->teraBytes(5));
    }

    public function testKibiBytes(): void
    {
        static::assertEquals(1048576, $this->size->kibiBytes());
    }

    public function testMebiBytes(): void
    {
        static::assertEquals(1024, $this->size->mebiBytes());
    }

    public function testGibiBytes(): void
    {
        static::assertEquals(1, $this->size->gibiBytes());
    }

    public function testTebiBytes(): void
    {
        static::assertEquals(0.00098, $this->size->tebiBytes(5));
    }

    public function testCallUnknownMethod(): void
    {
        static::expectException(\ErrorException::class);
        $this->size->unknownBytes();
    }

    public function testCallWithBadArgument(): void
    {
        static::expectException(\ErrorException::class);
        $this->size->megaBytes('string');
    }
}
