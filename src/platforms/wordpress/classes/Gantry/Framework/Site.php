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

/**
 * Class Site
 * @package Gantry\Framework
 */
class Site extends \Timber\Site
{
    /**
     * @param string $widget_id
     * @return \TimberFunctionWrapper
     */
    public function sidebar( $widget_id = '' )
    {
        return \TimberHelper::function_wrapper('dynamic_sidebar', [$widget_id], true);
    }
}
