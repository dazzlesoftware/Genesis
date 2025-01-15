<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

namespace Gantry\Component\Assignments;

/**
 * Interface AssignmentsInterface
 * @package Gantry\Component\Assignments
 */
interface AssignmentsInterface
{
    /**
     * Returns list of rules which apply to the current page.
     *
     * @return array
     */
    public function getRules();

    /**
     * List all the rules available.
     *
     * @param string $configuration
     * @return array
     */
    public function listRules($configuration);
}
