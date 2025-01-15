<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Joomla\Object;

use \Gantry\Component\Collection\Collection as BaseCollection;

/**
 * Class Collection
 * @package Gantry\Joomla\Object
 */
class Collection extends BaseCollection
{
    /**
     * Collection constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param string $property
     * @return array
     */
    public function get($property)
    {
        $list = [];

        if ($property === 'id') {
            return array_keys($this->items);
        }

        foreach ($this as $object) {
            $list[$object->id] = $object->{$property};
        }

        return $list;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return array
     */
    public function __call($name, $arguments)
    {
        $list = [];

        foreach ($this as $object) {
            $list[$object->id] = method_exists($object, $name) ? \call_user_func_array([$object, $name], $arguments) : null;
        }

        return $list;
    }

    public function exportSql()
    {
        $objects = [];
        foreach ($this as $object) {
            // Initialize table object.
            $objects[] = trim($object->exportSql());
        }

        $out = '';
        if ($objects) {
            $out .= implode("\n", $objects);
        }

        return $out;
    }
}
