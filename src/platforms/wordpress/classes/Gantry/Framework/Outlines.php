<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Framework;

use Gantry\Component\Outline\OutlineCollection;

/**
 * Class Outlines
 * @package Gantry\Framework
 */
class Outlines extends OutlineCollection
{
    /**
     * Returns list of all menu locations defined in outsets.
     *
     * @return array
     */
    public function menuLocations()
    {
        // TODO: add support for menu locations.
        return [];

        /*
        $list = ['main-navigation' => __('Main Navigation')];
        foreach ($this->items as $name => $title) {
            $index = Layout::index($name);

            $list += isset($index['menus']) ? $index['menus'] : [];
        }

        return $list;
        */
    }
}
