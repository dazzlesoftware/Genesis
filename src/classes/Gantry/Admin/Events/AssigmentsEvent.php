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
use Gantry\Framework\Assignments;
use Gantry\Framework\Gantry;
use Gantry\Framework\Theme;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class AssigmentsEvent
 * @package Gantry\Admin\Events
 */
class AssigmentsEvent extends EventDispatcher
{
    /** @var Gantry */
    public $gantry;
    /** @var Theme */
    public $theme;
    /** @var RestfulControllerInterface */
    public $controller;
    /** @var Assignments */
    public $assignments;
}
