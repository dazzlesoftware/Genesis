<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Gantry;

use Gantry\Framework\Gantry;

/**
 * Trait GantryTrait
 * @package Gantry\Component\Gantry
 */
trait GantryTrait
{
    /** @var Gantry */
    private static $gantry;

    /**
     * Get global Gantry instance.
     *
     * @return Gantry
     */
    public static function gantry()
    {
        // We cannot set variable directly for the trait as it doesn't work in HHVM.
        if (!self::$gantry) {
            self::$gantry = Gantry::instance();
        }

        return self::$gantry;
    }
}
