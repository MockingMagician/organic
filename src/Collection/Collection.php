<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Collection;

use MockingMagician\Organic\Helper\Collection as HelperCollection;
use MockingMagician\Organic\Inode;

class Collection extends HelperCollection
{
    public function __construct(array $values, array $acceptClasses)
    {
        parent::__construct($values, $acceptClasses);
        /** @var Inode $value */
        foreach ($values as $value) {
            $value->attachTo($this);
        }
    }
}
