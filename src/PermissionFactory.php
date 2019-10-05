<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

class PermissionFactory
{
    public static function defaultDirectory(): Permission
    {
        return new Permission(
            new PermissionScope(true, true, true),
            new PermissionScope(true, true, true),
            new PermissionScope(true, true, true)
        );
    }

    public static function defaultFile(): Permission
    {
        return new Permission(
            new PermissionScope(true, true, false),
            new PermissionScope(true, true, false),
            new PermissionScope(true, true, false)
        );
    }
}
