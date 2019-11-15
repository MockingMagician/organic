<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Helper;

class Path
{
    /**
     * There is a method that deal with Sven Arduwie proposal https://www.php.net/manual/en/function.realpath.php#84012
     * And runeimp at gmail dot com proposal https://www.php.net/manual/en/function.realpath.php#112367.
     */
    public static function clean(string $path): string
    {
        // Cleaning path regarding OS
        $path = \mb_ereg_replace('\\\\|/', \DIRECTORY_SEPARATOR, $path, 'msr');
        // Check if path start with a separator (UNIX)
        $startWithSeparator = \DIRECTORY_SEPARATOR === $path[0];
        // Check if start with drive letter
        \preg_match('/^[a-z]:/', $path ?: '', $matches);
        $startWithLetterDir = isset($matches[0]) ? $matches[0] : false;
        // Get and filter empty sub paths
        $subPaths = \array_filter(\explode(\DIRECTORY_SEPARATOR, $path ?: ''), function ($v) {
            return \mb_strlen($v);
        });

        $absolutes = [];
        foreach ($subPaths as $subPath) {
            if ('.' === $subPath) {
                continue;
            }
            // if $startWithSeparator is false
            // and $startWithLetterDir
            // and (absolutes is empty or all previous values are ..)
            // save absolute cause that's a relative and we can't deal with that and just forget that we want go up
            if ('..' === $subPath
                && !$startWithSeparator
                && !$startWithLetterDir
                && empty(\array_filter($absolutes, function ($value) { return !('..' === $value); }))
            ) {
                $absolutes[] = $subPath;

                continue;
            }
            if ('..' === $subPath) {
                \array_pop($absolutes);

                continue;
            }
            $absolutes[] = $subPath;
        }

        return
            (($startWithSeparator ? \DIRECTORY_SEPARATOR : $startWithLetterDir) ?
                $startWithLetterDir.\DIRECTORY_SEPARATOR : ''
            ).\implode(\DIRECTORY_SEPARATOR, $absolutes);
    }

    /*
     * Examples
     *
     * echo Path::getAbsolute('/one/two/../two/./three/../../two');            =>    /one/two
     * echo Path::getAbsolute('../one/two/../two/./three/../../two');          =>    ../one/two
     * echo Path::getAbsolute('../.././../one/two/../two/./three/../../two');  =>    ../../../one/two
     * echo Path::getAbsolute('../././../one/two/../two/./three/../../two');   =>    ../../one/two
     * echo Path::getAbsolute('/../one/two/../two/./three/../../two');         =>    /one/two
     * echo Path::getAbsolute('/../../one/two/../two/./three/../../two');      =>    /one/two
     * echo Path::getAbsolute('c:\.\..\one\two\..\two\.\three\..\..\two');     =>    c:/one/two
     *
     */
}
