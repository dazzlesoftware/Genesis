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

use Gantry\Component\Assignments\AbstractAssignments;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class Assignments
 * @package Gantry\Framework
 */
class Assignments extends AbstractAssignments
{
    /** @var string */
    protected $platform = 'WordPress';

    /**
     * Assignments constructor.
     * @param string|null $configuration
     */
    public function __construct($configuration = null)
    {
        parent::__construct($configuration);

        // Deal with special language assignments.
        $this->specialFilterMethod = function($candidate, $match, $page) {
            if (!empty($candidate['language']) && !empty($page['language'])) {
                // Always drop candidate if language does not match.
                if (empty($match['language'])) {
                    return false;
                }

                unset($candidate['language'], $match['language']);
                $candidate = array_filter($candidate);

                // Special check for the default outline of the language.
                return empty($candidate) || !empty($match);
            }

            return true;
        };
    }

    /**
     * @return array
     */
    public function types()
    {
        $types = [
            'context',
            'menu',
            'language',
            'post',
            'taxonomy',
            'archive'
        ];

        $gantry = Gantry::instance();

        $event = new Event;
        $event->types = $types;

        $gantry->fireEvent('assignments.types', $event);

        return \apply_filters('g5_assignments_types', $event->types);
    }

    /**
     * @return array
     */
    public function getPage()
    {
        $list = parent::getPage();

        \do_action('g5_assignments_page', $list);

        return $list;
    }
}
