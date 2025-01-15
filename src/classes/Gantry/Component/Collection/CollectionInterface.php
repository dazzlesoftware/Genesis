<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Collection;

/**
 * Interface CollectionInterface
 * @package Gantry\Component\Collection
 */
interface CollectionInterface extends \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @param mixed $item
     */
    public function add($item);

    /**
     * @return \ArrayIterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator();

    /**
     * @param string|int $offset
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset);

    /**
     * @param string|int $offset
     * @param mixed $value
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value);

    /**
     * @param string|int $offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset);

    /**
     * @param string|int $offset
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset);

    /**
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count();
}
