<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Collection;

use MockingMagician\Organic\Exception\CollectionValueException;
use MockingMagician\Organic\Helper\Collection as HelperCollection;
use MockingMagician\Organic\Inode\Base\AbstractInode;

abstract class AbstractCollection extends HelperCollection
{
    /**
     * Collection constructor.
     *
     * @throws CollectionValueException
     */
    public function __construct(array $values, array $acceptClasses)
    {
        parent::__construct($values, $acceptClasses);
    }

    /**
     * @param AbstractInode $a
     * @param AbstractInode $b
     */
    public function equals($a, $b): bool
    {
        return $a->getObjectPath() === $b->getObjectPath();
    }
}
