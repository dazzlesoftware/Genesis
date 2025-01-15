<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Framework\Markdown;

/**
 * Class Parsedown
 * @package Gantry\Framework\Markdown
 */
class Parsedown extends \Parsedown
{
    use ParsedownTrait;

    /**
     * Parsedown constructor.
     *
     * @param array|null $defaults
     */
    public function __construct(array $defaults = null)
    {
        $this->init($defaults ?: []);
    }

}
