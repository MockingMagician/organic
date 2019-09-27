<?php

namespace MockingMagician\Organic;


interface CollectionInterface
{
    public function add($value): CollectionInterface;
    public function remove($value): CollectionInterface;
    public function clear(): CollectionInterface;
    public function isAcceptableValue($value): bool;
}
