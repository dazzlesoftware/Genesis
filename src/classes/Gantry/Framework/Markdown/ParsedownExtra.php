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
 * Class ParsedownExtra
 * @package Gantry\Framework\Markdown
 */
class ParsedownExtra extends \ParsedownExtra
{
    use ParsedownTrait;

    /**
     * ParsedownExtra constructor.
     *
     * @param array|null $defaults
     * @throws \Exception
     */
    public function __construct(array $defaults = null)
    {
        parent::__construct();

        $this->init($defaults ?: []);
    }
}
