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
 * Class Page
 * @package Gantry\Framework
 */
class Page extends Base\Page
{
    /**
     * @param array $args
     * @return string
     */
    public function url(array $args = [])
    {
        throw new \Exception('Please override class');
    }
}
