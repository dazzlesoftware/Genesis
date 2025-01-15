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

use Gantry\Component\Controller\RestfulControllerInterface;
use Gantry\Component\Layout\Layout;
use Gantry\Framework\Gantry;
use Gantry\Framework\Theme;
use DazzleSoftware\Toolbox\Event\Event;

/**
 * Class LayoutEvent
 * @package Gantry\Admin\Events
 */
class LayoutEvent extends Event
{
    /** @var Gantry */
    public $gantry;
    /** @var Theme */
    public $theme;
    /** @var RestfulControllerInterface */
    public $controller;
    /** @var Layout */
    public $layout;
}
