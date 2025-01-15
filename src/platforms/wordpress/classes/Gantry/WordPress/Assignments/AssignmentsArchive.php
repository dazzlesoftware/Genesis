<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\WordPress\Assignments;

/**
 * Class AssignmentsArchive
 * @package Gantry\WordPress\Assignments
 */
class AssignmentsArchive extends AssignmentsTaxonomy
{
    /** @var string */
    public $type = 'archive';
    /** @var string */
    public $label = 'Archives: %s';
    /** @var int */
    public $priority = 6;
}
