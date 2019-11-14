<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Permission;

class PermissionFactory
{
    public static function createFromMode(int $mode): Permission
    {
        list($u, $g, $o) = static::getUGOFromMode($mode);

        return new Permission(
            static::createPermissionScopeFromInt($u),
            static::createPermissionScopeFromInt($g),
            static::createPermissionScopeFromInt($o)
        );
    }

    public static function defaultDirectory(): Permission
    {
        return new Permission(
            new PermissionScope(true, true, true),
            new PermissionScope(true, false, true),
            new PermissionScope(true, false, true)
        );
    }

    public static function defaultFile(): Permission
    {
        return new Permission(
            new PermissionScope(true, true, false),
            new PermissionScope(true, false, false),
            new PermissionScope(true, false, false)
        );
    }

    /**
     * @throws \RuntimeException
     *
     * @return array
     */
    private static function getUGOFromMode(int $mode)
    {
        $octal = \decoct($mode);

        if (1 === \mb_strlen($octal)) {
            return [0, 0, (int) $octal[0]];
        }

        if (2 === \mb_strlen($octal)) {
            return [0, (int) $octal[0], (int) $octal[1]];
        }

        if (3 === \mb_strlen($octal)) {
            return [(int) $octal[0], (int) $octal[1], (int) $octal[2]];
        }

        throw new \RuntimeException('$mode is not valid');
    }

    private static function createPermissionScopeFromInt(int $p)
    {
        if (0 === $p) {
            return new PermissionScope(false, false, false);
        }
        if (1 === $p) {
            return new PermissionScope(false, false, true);
        }
        if (2 === $p) {
            return new PermissionScope(false, true, false);
        }
        if (3 === $p) {
            return new PermissionScope(false, true, true);
        }
        if (4 === $p) {
            return new PermissionScope(true, false, false);
        }
        if (5 === $p) {
            return new PermissionScope(true, false, true);
        }
        if (6 === $p) {
            return new PermissionScope(true, true, false);
        }

        return new PermissionScope(true, true, true);
    }
}
