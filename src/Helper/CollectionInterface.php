<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 *
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Helper;

/**
 * Interface CollectionInterface.
 *
 * @internal
 */
interface CollectionInterface
{
    public function add($value): CollectionInterface;

    public function remove($value): CollectionInterface;

    public function clear(): CollectionInterface;

    public function isAcceptableValue($value): bool;

    public function equals($a, $b): bool;
}
