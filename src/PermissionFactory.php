<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic;

class PermissionFactory
{
    public static function createFromMode(int $mode): Permission
    {
        $octal = \decoct($mode);

        if (\mb_strlen($octal) > 3) {
            throw new \RuntimeException('$mode is not valid');
        }

        if (1 === \mb_strlen($octal)) {
            $u = 0;
            $g = 0;
            $o = (int) $octal[0];
        }

        if (2 === \mb_strlen($octal)) {
            $u = 0;
            $g = (int) $octal[0];
            $o = (int) $octal[1];
        }

        if (3 === \mb_strlen($octal)) {
            $u = (int) $octal[0];
            $g = (int) $octal[1];
            $o = (int) $octal[2];
        }

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
            new PermissionScope(true, true, true),
            new PermissionScope(true, true, true)
        );
    }

    public static function defaultFile(): Permission
    {
        return new Permission(
            new PermissionScope(true, true, false),
            new PermissionScope(true, true, false),
            new PermissionScope(true, false, false)
        );
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
        if (7 === $p) {
            return new PermissionScope(true, true, true);
        }

        throw new \RuntimeException('$p value can be 0 to 7 only');
    }
}
