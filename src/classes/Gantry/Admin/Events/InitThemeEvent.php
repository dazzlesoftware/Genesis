<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Admin\Events;

use Gantry\Admin\Theme;
use Gantry\Framework\Gantry;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class AssigmentsEvent
 * @package Gantry\Admin\Events
 */
class InitThemeEvent extends EventDispatcher
{
    /** @var Gantry */
    public $gantry;
    /** @var Theme */
    public $theme;
}
