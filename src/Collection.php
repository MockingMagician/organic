<?php

namespace MockingMagician\Organic;


use MockingMagician\Organic\Exception\CollectionValueException;
use Traversable;

class Collection implements CollectionInterface, \Countable, \IteratorAggregate
{
    /** @var \ArrayIterator */
    protected $iterator;
    /** @var string[] */
    private $acceptClasses;

    public function __construct(array $values = [], array $acceptClasses)
    {
        $this->acceptClasses = $acceptClasses;
        foreach ($values as $value) {
            if (!$this->isAcceptableValue($value)) {
                throw new CollectionValueException(static::class, get_class($value));
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

    public function add($value): CollectionInterface
    {
        if (!$this->isAcceptableValue($value)) {
            throw new CollectionValueException(static::class, get_class($value));
        }

        foreach ($this->iterator as $item) {
            if ($item == $value) {
                return $this;
            }
        }

        $this->iterator->append($value);

        return $this;
    }

    public function remove($value): CollectionInterface
    {
        if (!$this->isAcceptableValue($value)) {
            throw new CollectionValueException(static::class, get_class($value));
        }

        foreach ($this->iterator as $offset => $item) {
            if ($item == $value) {
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
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->iterator->count();
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return $this->iterator;
    }
}
