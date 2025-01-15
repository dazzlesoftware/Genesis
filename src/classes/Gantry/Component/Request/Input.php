<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Request;

use DazzleSoftware\Toolbox\ArrayTraits\Export;
use DazzleSoftware\Toolbox\ArrayTraits\ExportInterface;
use DazzleSoftware\Toolbox\ArrayTraits\Iterator;
use DazzleSoftware\Toolbox\ArrayTraits\NestedArrayAccessWithGetters;

/**
 * Class Input
 * @package Gantry\Component\Request
 */
class Input implements \ArrayAccess, \Iterator, ExportInterface
{
    use NestedArrayAccessWithGetters, Iterator, Export;

    /** @var array */
    protected $items;

    /**
     * Constructor to initialize array.
     *
     * @param  array  $items  Initial items inside the iterator.
     */
    public function __construct(array &$items = [])
    {
        $this->items = &$items;
    }

    /**
     * Returns input array. If there are any JSON encoded fields (key: _json), those will be decoded as well.
     *
     * @param string  $path       Dot separated path to the requested value.
     * @param mixed   $default    Default value (or null).
     * @param string  $separator  Separator, defaults to '.'
     * @return array
     */
    public function getArray($path = null, $default = null, $separator = '.')
    {
        $data = $path ? $this->get($path, $default, $separator) : $this->items;

        return (array) $this->getChildren($data);
    }

    /**
     * Returns JSON decoded input array.
     *
     * @param string  $path       Dot separated path to the requested value.
     * @param mixed   $default    Default value (or null).
     * @param string  $separator  Separator, defaults to '.'
     * @return array
     */
    public function getJsonArray($path = null, $default = null, $separator = '.')
    {
        return (array) $this->getJson($path, $default, $separator, true);
    }

    /**
     * Returns JSON decoded input. Accosiative arrays become objects.
     *
     * @param string|null  $path       Dot separated path to the requested value.
     * @param mixed        $default    Default value (or null).
     * @param string       $separator  Separator, defaults to '.'
     * @param bool         $assoc      True to return associative arrays instead of objects.
     * @return mixed
     */
    public function getJson($path = null, $default = null, $separator = '.', $assoc = false)
    {
        $data = $this->get($path, null, $separator);

        if (!isset($data)) {
            return $default;
        }

        if (!is_string($data)) {
            throw new \RuntimeException(sprintf('%s::%s(%s) expects input to be JSON encoded string', __CLASS__, __FUNCTION__, $path));
        }

        $data = json_decode($data, $assoc);
        if (!isset($data)) {
            throw new \RuntimeException(sprintf('%s::%s(): %s', __CLASS__, __FUNCTION__, json_last_error_msg()));
        }

        return $data;
    }

    /**
     * @param array|mixed $current
     * @return array|mixed
     * @internal
     */
    protected function getChildren(&$current)
    {
        if (!is_array($current)) {
            return $current;
        }

        $array = [];
        foreach ($current as $key => &$value) {
            if ($key === '_json') {
                $array += json_decode($value, true);
            } else {
                $array[$key] = $this->getChildren($value);
            }
        }

        return $array;
    }
}
