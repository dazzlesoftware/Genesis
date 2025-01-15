<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\WordPress;

class NavMenuEditWalker extends \Walker_Nav_Menu_Edit
{
    public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 )
    {
        parent::start_el($output, $item, $depth, $args, $id);

        if ('custom' !== $item->type || strpos($item->attr_title, 'gantry-particle-') !== 0) {
            return;
        }

        $output = str_replace('field-url', 'field-url hidden', $output);
    }
}
