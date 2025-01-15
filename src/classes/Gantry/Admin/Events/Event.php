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
use Gantry\Framework\Gantry;

/**
 * Class AssigmentsEvent
 * @package Gantry\Admin\Events
 */
class Event extends \DazzleSoftware\Toolbox\Event\Event
{
    /** @var Gantry */
    public $gantry;
    /** @var RestfulControllerInterface */
    public $controller;
    /** @var array */
    public $data;
}
