<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Tests\Permission;

use MockingMagician\Organic\Permission\PermissionFactory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class PermissionFactoryTest extends TestCase
{
    public function testDefaultDirectoryReturn0755(): void
    {
        $permission = PermissionFactory::defaultDirectory();
        static::assertEquals(7, $permission->getUser()->getP());
        static::assertEquals(5, $permission->getGroup()->getP());
        static::assertEquals(5, $permission->getOthers()->getP());
    }

    public function testDefaultFileReturn0644(): void
    {
        $permission = PermissionFactory::defaultFile();
        static::assertEquals(6, $permission->getUser()->getP());
        static::assertEquals(4, $permission->getGroup()->getP());
        static::assertEquals(4, $permission->getOthers()->getP());
    }

    public function testCreateFromMode(): void
    {
        $permission = PermissionFactory::createFromMode(0777);
        static::assertEquals(7, $permission->getUser()->getP());
        static::assertEquals(7, $permission->getGroup()->getP());
        static::assertEquals(7, $permission->getOthers()->getP());

        $permission = PermissionFactory::createFromMode(0000);
        static::assertEquals(0, $permission->getUser()->getP());
        static::assertEquals(0, $permission->getGroup()->getP());
        static::assertEquals(0, $permission->getOthers()->getP());

        $permission = PermissionFactory::createFromMode(0020);
        static::assertEquals(0, $permission->getUser()->getP());
        static::assertEquals(2, $permission->getGroup()->getP());
        static::assertEquals(0, $permission->getOthers()->getP());

        $permission = PermissionFactory::createFromMode(0111);
        static::assertEquals(1, $permission->getUser()->getP());
        static::assertEquals(1, $permission->getGroup()->getP());
        static::assertEquals(1, $permission->getOthers()->getP());

        $permission = PermissionFactory::createFromMode(0765);
        static::assertEquals(7, $permission->getUser()->getP());
        static::assertEquals(6, $permission->getGroup()->getP());
        static::assertEquals(5, $permission->getOthers()->getP());

        $permission = PermissionFactory::createFromMode(0432);
        static::assertEquals(4, $permission->getUser()->getP());
        static::assertEquals(3, $permission->getGroup()->getP());
        static::assertEquals(2, $permission->getOthers()->getP());

        $permission = PermissionFactory::createFromMode(0741);
        static::assertEquals(7, $permission->getUser()->getP());
        static::assertEquals(4, $permission->getGroup()->getP());
        static::assertEquals(1, $permission->getOthers()->getP());

        static::expectException(\RuntimeException::class);
        PermissionFactory::createFromMode(9999);
    }

    public function testCreatePermissionScopeFromInt(): void
    {
        static::expectException(\RuntimeException::class);
        PermissionFactory::createFromMode(789);
    }
}
