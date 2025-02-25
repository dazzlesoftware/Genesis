<?php

/**
 * @package   Genesis
 * @author    Dazzle Software https://www.dazzlesoftware.org
 * @copyright Copyright (C) 2025 Dazzle Software, LLC
 * @license   Dual License: GNU/GPLv3 and later
 *
 * Genesis Framework code that extends GPL code is considered GNU/GPLv3 and later
 */

defined('_JEXEC') or die ();

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Component\Router\RouterBase;
use Joomla\CMS\Factory;

/**
 * Class Gantry5Router
 */
class Gantry5Router extends RouterBase
{
    /**
     * Build the route for the Gantry5 component
     *
     * @param   array  &$query  An array of URL arguments
     * @return  array  The URL arguments to use to assemble the subsequent URL.
     */
    public function build(&$query)
    {
        $segments = array();

        unset($query['view']);

        return $segments;
    }

    /**
     * Parse the segments of a URL.
     *
     * @param   array  &$segments  The segments of the URL to parse.
     * @return  array  The URL attributes to be used by the application.
     */
    public function parse(&$segments)
    {
        if ($segments) {
            return array('g5_not_found' => 1);
        }

        return array();
    }
}

/**
 * Content router functions
 *
 * These functions are proxys for the new router interface
 * for old SEF extensions.
 *
 * @param   array  &$query  An array of URL arguments
 *
 * @return  array  The URL arguments to use to assemble the subsequent URL.
 */
function Gantry5BuildRoute(&$query)
{
    /** @var CMSApplication $app */
	$app = Factory::getApplication();
	$router = new Gantry5Router($app, $app->getMenu());

	return $router->build($query);
}

/**
 * Parse the segments of a URL.
 *
 * This function is a proxy for the new router interface
 * for old SEF extensions.
 *
 * @param   array  $segments  The segments of the URL to parse.
 * @return  array  The URL attributes to be used by the application.
 */
function Gantry5ParseRoute($segments)
{
    /** @var CMSApplication $app */
    $app = Factory::getApplication();
	$router = new Gantry5Router($app, $app->getMenu());

	return $router->parse($segments);
}
