<?php

/**
 * @author Marc MOREAU <moreau.marc.web@gmail.com>
 * @license https://github.com/MockingMagician/organic/blob/master/LICENSE.md CC-BY-SA-4.0
 * @link https://github.com/MockingMagician/organic/blob/master/README.md
 */

namespace MockingMagician\Organic\Helper;

use MockingMagician\Organic\Exception\CollectionValueException;
use Traversable;

/**
 * Class Collection.
 *
 * @internal
 */
abstract class Collection implements CollectionInterface, \Countable, \IteratorAggregate
{
    /** @var \ArrayIterator */
    protected $iterator;
    private $acceptClasses;

    /**
     * Collection constructor.
     *
     * @throws CollectionValueException
     */
    public function __construct(array $values, array $acceptClasses)
    {
        $this->acceptClasses = $acceptClasses;
        foreach ($values as $value) {
            if (!$this->isAcceptableValue($value)) {
                throw new CollectionValueException(static::class, $value);
            }
        }
        $this->iterator = new \ArrayIterator($values);
    }

    public function isAcceptableValue($value): bool
    {
        foreach ($this->acceptClasses as $class) {
            if ($value instanceof $class) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param mixed $value
     *
     * @throws CollectionValueException
     */
    public function add($value): CollectionInterface
    {
        if (!$this->isAcceptableValue($value)) {
            throw new CollectionValueException(static::class, $value);
        }

        foreach ($this->iterator as $item) {
            if ($this->equals($item, $value)) {
                return $this;
            }
        }

        $this->iterator->append($value);

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @throws CollectionValueException
     */
    public function remove($value): CollectionInterface
    {
        if (!$this->isAcceptableValue($value)) {
            throw new CollectionValueException(static::class, $value);
        }

        foreach ($this->iterator as $offset => $item) {
            if ($this->equals($item, $value)) {
                $this->iterator->offsetUnset($offset);

                return $this;
            }
        }

        return $this;
    }

    public function clear(): CollectionInterface
    {
        $this->iterator = new \ArrayIterator();

        return $this;
    }

    /**
     * Count elements of an object.
     *
     * @see http://php.net/manual/en/countable.count.php
     *
     * @return int the custom count as an integer.
     *             </p>
     *             <p>
     *             The return value is cast to an integer
     *
     * @since 5.1.0
     */
    public function count()
    {
        return $this->iterator->count();
    }

    /**
     * Retrieve an external iterator.
     *
     * @see http://php.net/manual/en/iteratoraggregate.getiterator.php
     *
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *                     <b>Traversable</b>
     *
     * @since 5.0.0
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    abstract public function equals($a, $b): bool;
}
